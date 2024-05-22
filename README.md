<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
goolancer_server_v1
├─ .env
├─ .env.example
├─ app
│  ├─ Console
│  │  └─ Kernel.php
│  ├─ Exceptions
│  │  └─ Handler.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Admin
│  │  │  │  ├─ AdminController.php
│  │  │  │  ├─ CertificateController.php
│  │  │  │  ├─ OrderController.php
│  │  │  │  ├─ PaymentController.php
│  │  │  │  ├─ PostController.php
│  │  │  │  ├─ ServiceController.php
│  │  │  │  └─ UserAccountController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthController.php
│  │  │  │  └─ EmailController.php
│  │  │  ├─ Base
│  │  │  │  └─ BaseController.php
│  │  │  ├─ Booking
│  │  │  │  └─ BookingRequestController.php
│  │  │  ├─ Certificate
│  │  │  │  └─ ExpertCertificateController.php
│  │  │  ├─ Common
│  │  │  │  └─ CommonController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ Job
│  │  │  │  └─ JobController.php
│  │  │  ├─ Post
│  │  │  │  └─ ExpertPostController.php
│  │  │  ├─ Revenue
│  │  │  │  └─ ExpertRevenueController.php
│  │  │  ├─ Service
│  │  │  │  └─ ExpertServiceController.php
│  │  │  └─ User
│  │  │     └─ UserDetailsController.php
│  │  ├─ Kernel.php
│  │  └─ Middleware
│  │     ├─ Authenticate.php
│  │     ├─ CheckLoggedIn.php
│  │     ├─ EncryptCookies.php
│  │     ├─ PreventRequestsDuringMaintenance.php
│  │     ├─ RedirectIfAuthenticated.php
│  │     ├─ TrimStrings.php
│  │     ├─ TrustHosts.php
│  │     ├─ TrustProxies.php
│  │     ├─ ValidateSignature.php
│  │     └─ VerifyCsrfToken.php
│  ├─ Models
│  │  ├─ Booking
│  │  │  ├─ BookingRequest.php
│  │  │  ├─ BookingRequestImage.php
│  │  │  └─ BookingRequestNegotiation.php
│  │  ├─ Certificate
│  │  │  ├─ ExpertCertificate.php
│  │  │  └─ ExpertCertificateLink.php
│  │  ├─ Job
│  │  │  ├─ JobMain.php
│  │  │  ├─ JobPayment.php
│  │  │  ├─ JobResult.php
│  │  │  ├─ JobResultComment.php
│  │  │  ├─ JobResultFile.php
│  │  │  └─ JobUserRating.php
│  │  ├─ Post
│  │  │  ├─ ExpertPost.php
│  │  │  └─ ExpertPostLink.php
│  │  ├─ Revenue
│  │  │  ├─ ExpertRevenueAccount.php
│  │  │  ├─ RefundRequest.php
│  │  │  └─ TransactionHistory.php
│  │  ├─ Service
│  │  │  └─ ExpertService.php
│  │  ├─ User
│  │  │  ├─ RoleValidity.php
│  │  │  ├─ UserLogin.php
│  │  │  └─ UserProfile.php
│  │  └─ User.php
│  └─ Providers
│     ├─ AppServiceProvider.php
│     ├─ AuthServiceProvider.php
│     ├─ BroadcastServiceProvider.php
│     ├─ EventServiceProvider.php
│     └─ RouteServiceProvider.php
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  └─ bootstrap.js
│  └─ views
│     ├─ admin
│     │  ├─ add_in_house_expert.blade.php
│     │  ├─ admin_dashboard.blade.php
│     │  ├─ approval
│     │  │  ├─ cert_approval.blade.php
│     │  │  ├─ payment_approval.blade.php
│     │  │  ├─ post_approval.blade.php
│     │  │  ├─ refund_approval.blade.php
│     │  │  ├─ service_approval.blade.php
│     │  │  ├─ transaction_history_approval.blade.php
│     │  │  ├─ view_cert.blade.php
│     │  │  ├─ view_post.blade.php
│     │  │  ├─ view_refund.blade.php
│     │  │  └─ view_transaction_history.blade.php
│     │  ├─ auth
│     │  │  ├─ login.blade.php
│     │  │  └─ register.blade.php
│     │  ├─ body
│     │  │  ├─ footer.blade.php
│     │  │  ├─ header.blade.php
│     │  │  └─ sidebar.blade.php
│     │  ├─ index.blade.php
│     │  ├─ user_account.blade.php
│     │  ├─ view_all_cert.blade.php
│     │  ├─ view_all_order.blade.php
│     │  ├─ view_all_post.blade.php
│     │  ├─ view_all_service.blade.php
│     │  ├─ view_cert.blade.php
│     │  ├─ view_order.blade.php
│     │  ├─ view_post.blade.php
│     │  ├─ view_service.blade.php
│     │  └─ view_user_profile.blade.php
│     ├─ image_viewer.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ api.php
│  ├─ channels.php
│  ├─ console.php
│  └─ web.php
