<?php

namespace App\Models\Scopes;

use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class Filterable
 * @package App
 *
 * @TODO: Create conditional operator for queries (AND, OR);
 * @TODO: Restrict operators to avoid unexpected programming mistakes;
 * @TODO: Improve class implementation: make properties declaration required or default.
 */
trait Filterable
{

    /**
     * @var string
     */
    private $delimiter = ',';

    /**
     * @var bool
     */
    protected $withRange = true;

    /**
     * @var array
     *
    protected $filterable = [
        'attrinute, // Default operator is '='
        'attribute' => ['=', '!=', '>', '<', '>=', '<='],
    ];
     */

    /**
     * @var array
     *
    protected $orderable = [
        'attribute',
    ];
     */

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function scopeCreatedAt($query, $parameters)
    {
        if (is_array($parameters) && isset($parameters['from']) && isset($parameters['to'])) {
            return $query->whereBetween('created_at', [$parameters['from'], $parameters['to']]);
        }
        return  $query;
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function scopeSearchOrFilter($query, $parameters)
    {
        $query = self::returnSearched($query, $parameters);
        $query = self::returnFiltered($query, $parameters);
        $query = self::returnOnRange($query, $parameters);
        return self::returnOrdered($query, $parameters);
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function scopeFilter($query, $parameters)
    {
        $query = self::returnFiltered($query, $parameters);

        return self::returnOrdered($query, $parameters);
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function scopeSearch($query, $parameters)
    {
        $query = self::returnSearched($query, $parameters);

        return self::returnOrdered($query, $parameters);
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    private function returnOrdered($query, $parameters)
    {
        if (isset($parameters['order_by'])) {

            $order = explode($this->delimiter, $parameters['order_by']);
            $orderable = $this->getOrderable();

            if (in_array($order[0], $orderable)) {

                $related_order = explode('.', $order[0]);
                $type = ((count($order) > 1) && in_array($order[1], ['desc', 'asc'])) ? $order[1] : 'asc';
                $column = $order[0];

                if (count($related_order) > 1) {
                    // To work, relationship must respect the convention: table names in plural (names), relationship name in singular (name_id).
                    // @TODO: Make it in a way that we can retrieve the relationship custom fields, instead of plural convention.
                    // @TODO: Make it work with hasOne relationships. Actualy it works only with belongsTo.
                    $query->select(Str::plural($related_order[0]) . '.*', $this->getTable() . '.*');
                    $query->join(Str::plural($related_order[0]), Str::plural($related_order[0]) . ".id", '=', $related_order[0] . "_id");
                    $column = Str::plural($related_order[0]) . '.' . $related_order[1];
                }

                $query->orderBy($column, $type);
            }
        } else {

            // Get the model default order
            $order = $this->getDefaultOrder();
            $query->orderBy($order[0], $order[1]);

            // Return the latest
            //$query->latest();
        }

        return $query;
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    private function returnSearched($query, $parameters)
    {
        if (isset($parameters['search'])) {

            $cols = self::getSearchable();

            if (count($cols)) {

                $query->where(function ($query) use ($parameters, $cols) {

                    foreach ($cols as $col) {

                        $related_search = explode('.', $col);

                        if (count($related_search) > 1) {
                            $query->orWhereHas(str_replace(':', '.', $related_search[0]), function ($q) use ($related_search, $parameters) {
                                $q->where($related_search[1], 'iLIKE', "%{$parameters['search']}%");
                            });
                        } else {
                            $query->orWhere($col, 'iLIKE', "%{$parameters['search']}%");
                        }
                    }
                });
            }
        }
        return $query;
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    private function returnFiltered($query, $parameters)
    {
        foreach ($parameters as $p => $v) {
            $query->where(function ($query) use ($p, $v) {

                // Explode by the default delimiter to check if the operator was sent
                $v = explode($this->delimiter, $v);

                // Validate and get the operator for the current attribute
                $op = $this->getOperator($p, $v);

                if ($op) {

                    $related_filter = explode('.', $op['p']);

                    if ($v[0] != '') {
                        if (count($related_filter) > 1) {

                            $query->orWhereHas(str_replace(':', '.', $related_filter[0]), function ($q) use ($related_filter, $op, $v) {
                                if (count($v) > 1) {
                                    $q->whereIn($related_filter[1], $v);
                                } else {
                                    $q->where($related_filter[1], $op['o'], $v[0]);
                                }
                            });
                        } else {

                            $query->orWhere($p, $op['o'], $v[0]);
                        }
                    }
                }
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function returnOnRange($query, $parameters)
    {
        if ($this->withRange && isset($parameters['from']) && isset($parameters['to'])) {

            $range_by = (isset($parameters['range_by'])) ? $parameters['range_by'] : 'created_at';

            if (in_array($range_by, self::getRangeable())) {

                $related_range_filter = explode('.', $range_by);

                if (count($related_range_filter) > 1) {

                    //@TODO: Create date range filter based on relationship

                } else {

                    $query->where($range_by, '>=', Carbon::createFromFormat('Y-m-d H:i:s', $parameters['from'] . ' 00:00:00'))
                        ->where($range_by, '<=', Carbon::createFromFormat('Y-m-d H:i:s', $parameters['to'] . ' 23:59:59'));
                }
            }
        }

        return $query;
    }

    /**
     * @param string $p
     * @param array $v
     * @return array|null
     */
    private function getOperator($p, $v)
    {
        $filterable = $this->getFilterable();
        $params = [$p, str_replace("_", ".", $p)];

        foreach ($params as $p) {

            if (array_key_exists($p, $filterable)) {

                return [
                    'p' => $p,
                    'o' => ((count($v) > 1) && in_array($v[1], $filterable[$p])) ? $v[1] : null
                ];
            }

            if (in_array($p, $filterable)) {

                return [
                    'p' => $p,
                    'o' => (count($v) == 1) ? '=' : (($v[1] == '=') ? $v[1] : null)
                ];
            }
        }

        return null;
    }

    /**
     * @return array
     *
     * @TODO: Consider the use of fillable attributes as default filterable attributes
     */
    private function getFilterable()
    {
        return ($this->filterable ?? [
            'created_at'
        ]);
    }

    /**
     * @return array
     *
     * @TODO: Consider the use of fillable attributes as default orderable attributes
     */
    private function getOrderable()
    {
        return ($this->orderable ?? [
            'id'
        ]);
    }

    /**
     * @return array
     */
    private function getRangeable()
    {
        return ($this->rangeable ?? [
            'created_at'
        ]);
    }

    /**
     * @return array
     *
     * @TODO: Consider the use of fillable attributes as default orderable attributes
     */
    private function getSearchable()
    {
        return ($this->searchable ?? [
            'name'
        ]);
    }

    /**
     * @return array
     */
    private function getDefaultOrder()
    {
        return explode(
            $this->delimiter,
            $this->defaultOrder ?? 'id,desc'
        );
    }
}
