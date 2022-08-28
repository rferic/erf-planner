<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;
use App\UseCases\HasQueryBuilderFilter;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    use HasQueryBuilderFilter;

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
}
