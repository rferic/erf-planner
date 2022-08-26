<?php

namespace App\UseCases\Core\User;

use App\Helpers\QueryBuilder\Filters;
use App\Models\Core\User;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected ?string $search = null,
        protected ?Filters $filters = null
    )
    {}

    public function action(): \Illuminate\Database\Eloquent\Builder
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filters) {
            if ($filter_emails = $this->filters->filter('emails')) {
                $query->whereIn('email', $filter_emails);
            }

            if ($filter_email = $this->filters->filter('email')) {
                $query->where(
                    'email',
                    $filter_email['operator'],
                    $this->parseValueToOperator($filter_email['operator'], $filter_email['value'])
                );
            }

            if ($filter_name = $this->filters->filter('name')) {
                $query->where(
                    'name',
                    $filter_name['operator'],
                    $this->parseValueToOperator($filter_name['operator'], $filter_name['value'])
                );
            }

            if ($filter_role = $this->filters->filter('role')) {
                $query->whereHas('roles', function ($query) use ($filter_role) {
                    $query->whereIn('name', $filter_role);
                });
            }
        }

        return $query;
    }

    private function parseValueToOperator(string $operator, string $value): string
    {
        return match ($operator) {
            'like', 'notLike' => '%'.$value.'%',
            default => $value,
        };
    }
}
