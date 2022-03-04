<?php


namespace MP\Base\Http\Filters\Filter;


use MP\Base\Http\Filters\Query\RelationQuery;
use MP\Base\Http\Filters\Query\SelfQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{

    protected $request;
    protected $filters = [];
    protected $queries = [
        'self' => SelfQuery::class,
        'relation' => RelationQuery::class
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder|void
     * @throws \Exception
     * filter by relation or same table
     * @author khalid
     */
    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            if (gettype($this->filters[$filter]) != 'array') {
                (new $this->filters[$filter])->filter($builder, $value);
            }
            else {
                $this->resolveFilter($this->filters[$filter]['type'])->filter($builder,
                    $this->prepareQuery($value, $this->filters[$filter]));
            }
        }
        return $builder;
    }

    /**
     * @return array
     * get all values from request whose keys are in $filter
     * @author khalid
     */
    public function getFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)), function ($value) {
            return ($value !== null && $value !== '');
        });
    }

    /**
     * @param $filter
     * @return mixed
     * @author khalid
     */
    public function resolveFilter($filter)
    {
        return new $this->queries[$filter];
    }

    function queryTemplate()
    {
        return [
            'like' => '%{value}%',
            '=' => '{value}',
            '!=' => '{value}',
            '<>' => '{value}',
            '<' => '{value}',
            '>' => '{value}',
            '<=' => '{value}',
            '>=' => '{value}',
        ];
    }

    public function filterMethods()
    {
        return [
            'date' => 'whereDate',
            'month' => 'whereMonth',
            'day' => 'whereDay',
            'year' => 'whereYear',
            'time' => 'whereTime'
        ];
    }

    /**
     * @param $filter
     * @return array
     * merge method with $filter
     * @author khalid
     */
    public function prepareMethod($filter)
    {
        if (!array_key_exists('attribute', $filter))
            return array_merge($filter, ['method' => 'where']);

        $method = $this->filterMethods()[$filter['attribute']];
        return array_merge($filter, ['method' => $method]);
    }

    /**
     * @param $value
     * @param $filter
     * @return array
     * @throws \Exception
     * prepare query with value
     * @author khalid
     */
    public function prepareQuery($value, $filter)
    {
        try {
            $template = $this->queryTemplate()[$filter['operand']];
            $replace = str_replace('{value}', strtolower(urldecode($value)), $template);
            return array_merge($this->prepareMethod($filter), ['value' => $replace]);
        } catch (\Exception $exception) {
            throw new \Exception('invalid operand or attribute');
        }
    }
}
