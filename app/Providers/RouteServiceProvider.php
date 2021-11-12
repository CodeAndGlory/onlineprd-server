<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentUserRole;
use App\Models\Eclass;
use App\Models\EmailTemplate;
use App\Models\FormFieldLookup;
use App\Models\NonCourseAssignment;
use App\Models\Offering;
use App\Models\PartOfTerm;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Letter;
use App\Models\Tag;
use App\Models\Term;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::model('assignment', Assignment::class);
        Route::model('non_course_assignment', NonCourseAssignment::class);
        Route::model('comment', Comment::class);
        Route::model('course', Course::class);
        Route::model('department', Department::class);
        Route::model('form_field_lookup', FormFieldLookup::class);
        Route::model('email_template', EmailTemplate::class);
        Route::model('letter', Letter::class);
        Route::model('offering', Offering::class);
        Route::model('parts_of_term', PartOfTerm::class);
        Route::model('permission', Permission::class);
        Route::model('role', Role::class);
        Route::model('department_user_role', DepartmentUserRole::class);
        Route::model('term', Term::class);
        Route::model('user', User::class);
        Route::model('tag', Tag::class);
        Route::model('eclass', Eclass::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
