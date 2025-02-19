<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'location', 'salary', 'experience', 'category',
    ];

    public function JobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    // limiting a user to one application per job
    public function hasUserApplied(Authenticatable | User | int $user): bool
{
    return $this->where('id', $this->id)
        ->whereHas('jobApplications', function ($query) use ($user) {
            $query->where('user_id', '=', $user->id ?? $user);
        })->exists();
}

    // This job belongs to a specific employer
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public static array $experience = ['Entry', 'Intermediate', 'Senior'];

    public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];

    public function scopeFilter(Builder | QueryBuilder $query, array $filters): Builder | QueryBuilder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('employer', function ($query) use ($search) {
                        $query->where('company_name', 'like', '%' . $search . '%');
                    });;
            });
        })->when($filters['min_salary'] ?? null, function ($query, $minsalary) {
            $query->where('salary', '>=', $minsalary);
        })->when($filters['max_salary'] ?? null, function ($query, $maxsalary) {
            $query->where('salary', '<=', $maxsalary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', $experience);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });
    }
}
