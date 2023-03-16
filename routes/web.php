<?php
# Backend Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\HelperController;
use App\Http\Controllers\Backend\TestController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ArticleController;
use App\Http\Controllers\Backend\ArticleCommentController;
use App\Http\Controllers\Backend\SiteMapController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\RedirectionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\TrafficsController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\MenuLinkController;
use App\Http\Controllers\Backend\FileController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\ContactReplyController;
use App\Http\Controllers\Backend\AnnouncementController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\UserPermissionController;
use App\Http\Controllers\Backend\UserRoleController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\PluginController;

# Frontend Controllers
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontendProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::get('/admin/getintocontrolpanel', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/admin/getintocontrolpanel', [LoginController::class, 'login']);
        Route::post('/admin/logoutfromtocontrolpanel', [LoginController::class, 'logout'])->name('logout');



//Route::prefix('dashboard')->middleware(['auth', 'ActiveAccount', 'verified'])->name('user.')->group(function () {
//    Route::get('/', [FrontendProfileController::class, 'dashboard'])->name('dashboard');
//    Route::get('/support', [FrontendProfileController::class, 'support'])->name('support');
//    Route::get('/support/create-ticket', [FrontendProfileController::class, 'create_ticket'])->name('create-ticket');
//    Route::post('/support/create-ticket', [FrontendProfileController::class, 'store_ticket'])->name('store-ticket');
//    Route::get('/support/{ticket}', [FrontendProfileController::class, 'ticket'])->name('ticket');
//    Route::post('/support/{ticket}/reply', [FrontendProfileController::class, 'reply_ticket'])->name('reply-ticket');
//    Route::get('/notifications', [FrontendProfileController::class, 'notifications'])->name('notifications');
//    Route::prefix('profile')->name('profile.')->group(function () {
//        Route::get('/settings', [FrontendProfileController::class, 'profile_edit'])->name('edit');
//        Route::put('/update', [FrontendProfileController::class, 'profile_update'])->name('update');
//        Route::put('/update-password', [FrontendProfileController::class, 'profile_update_password'])->name(
//            'update-password'
//        );
//        Route::put('/update-email', [FrontendProfileController::class, 'profile_update_email'])->name('update-email');
//    });
//});

        Route::prefix('admin')->middleware(['auth', 'ActiveAccount'])->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::middleware('auth')->group(function () {
                Route::resource('announcements', AnnouncementController::class);
                Route::resource('files', FileController::class);
                Route::post('contacts/resolve', [ContactController::class, 'resolve']);
                Route::resource('contacts', ContactController::class);
                Route::resource('menus', MenuController::class);
                Route::get('users/{user}/access', [UserController::class, 'access'])->name('users.access');
                Route::resource('users', UserController::class);
                Route::resource('roles', RoleController::class);
                Route::get('user-roles/{user}', [UserRoleController::class, 'index'])->name('users.roles.index');
                Route::put('user-roles/{user}', [UserRoleController::class, 'update'])->name(
                    'users.roles.update'
                );
                Route::resource('articles', ArticleController::class);
                Route::post('article-comments/change_status', [ArticleCommentController::class, 'change_status']
                )->name(
                    'article-comments.change_status'
                );
                Route::resource('article-comments', ArticleCommentController::class);
                Route::resource('pages', PageController::class);
                Route::resource('tags', TagController::class);
                Route::resource('contact-replies', ContactReplyController::class);
                Route::post('faqs/order', [FaqController::class, 'order'])->name('faqs.order');
                Route::resource('faqs', FaqController::class);
                Route::post('menu-links/get-type', [MenuLinkController::class, 'getType'])->name(
                    'menu-links.get-type'
                );
                Route::post('menu-links/order', [MenuLinkController::class, 'order'])->name('menu-links.order');
                Route::resource('menu-links', MenuLinkController::class);
                Route::resource('categories', CategoryController::class);
                Route::resource('redirections', RedirectionController::class);
                Route::get('traffics', [TrafficsController::class, 'index'])->name('traffics.index');
                Route::get('traffics/logs', [TrafficsController::class, 'logs'])->name('traffics.logs');
                Route::get('error-reports', [TrafficsController::class, 'error_reports'])->name(
                    'traffics.error-reports'
                );
                Route::post('clear-error-reports', [TrafficsController::class, 'clear_error_reports'])->name(
                    'error-reports.clear'
                );
                Route::get('error-reports/{report}', [TrafficsController::class, 'error_report'])->name(
                    'traffics.error-report'
                );

                Route::prefix('settings')->name('settings.')->group(function () {
                    Route::get('/', [SettingController::class, 'index'])->name('index');
                    Route::put('/update', [SettingController::class, 'update'])->name('update');
                });
            });

            Route::prefix('upload')->name('upload.')->group(function () {
                Route::post('/image', [HelperController::class, 'upload_image'])->name('image');
                Route::post('/file', [HelperController::class, 'upload_file'])->name('file');
                Route::post('/remove-file', [HelperController::class, 'remove_files'])->name('remove-file');
            });

            Route::prefix('plugins')->name('plugins.')->group(function () {
                Route::get('/', [PluginController::class, 'index'])->name('index');
                Route::get('/create', [PluginController::class, 'create'])->name('create');
                Route::post('/create', [PluginController::class, 'store'])->name('store');
                Route::post('/{plugin}/activate', [PluginController::class, 'activate'])->name('activate');
                Route::post('/{plugin}/deactivate', [PluginController::class, 'deactivate'])->name('deactivate');
                Route::post('/{plugin}/delete', [PluginController::class, 'delete'])->name('delete');
            });

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'index'])->name('index');
                Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
                Route::put('/update', [ProfileController::class, 'update'])->name('update');
                Route::put('/update-password', [ProfileController::class, 'update_password'])->name(
                    'update-password'
                );
                Route::put('/update-email', [ProfileController::class, 'update_email'])->name('update-email');
            });

            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', [NotificationsController::class, 'index'])->name('index');
                Route::get('/ajax', [NotificationsController::class, 'ajax'])->name('ajax');
                Route::post('/see', [NotificationsController::class, 'see'])->name('see');
                Route::get('/create', [NotificationsController::class, 'create'])->name('create');
                Route::post('/create', [NotificationsController::class, 'store'])->name('store');
            });
        });

//
//Route::get('/login/google/redirect', [LoginController::class, 'redirect_google']);
//Route::get('/login/google/callback', [LoginController::class, 'callback_google']);
//Route::get('/login/facebook/redirect', [LoginController::class, 'redirect_facebook']);
//Route::get('/login/facebook/callback', [LoginController::class, 'callback_facebook']);

        Route::get('blocked', [HelperController::class, 'blocked_user'])->name('blocked');
        Route::get('robots.txt', [HelperController::class, 'robots']);
        Route::get('manifest.json', [HelperController::class, 'manifest'])->name('manifest');
        Route::get('sitemap.xml', [SiteMapController::class, 'sitemap']);
        Route::get('sitemaps/links', [SiteMapController::class, 'custom_links']);
        Route::get('sitemaps/{name}/{page}/sitemap.xml', [SiteMapController::class, 'viewer']);


        Route::get('/', [FrontController::class, 'index'])->name('home');
        Route::view('/contact', 'front.pages.contact')->name('contact');
        Route::get('/page/{page}', [FrontController::class, 'page'])->name('page.show');
        Route::get('/tag/{tag}', [FrontController::class, 'tag'])->name('tag.show');
        Route::get('/category/{category}', [FrontController::class, 'category'])->name('category.show');
        Route::get('/article/{slug}', [FrontController::class, 'article'])->name('article.show');
        Route::get('/blog', [FrontController::class, 'blog'])->name('blog');
        Route::get('/tests', [FrontController::class, 'tests'])->name('tests');
        Route::post('/contact', [FrontController::class, 'contact_post'])->name('contact-post');
        Route::post('/comment', [FrontController::class, 'comment_post'])->name('comment-post');
    }
);
