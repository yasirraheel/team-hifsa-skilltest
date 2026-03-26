# Cron Job Setup for Bulk Lesson Import Queue Processing
# This file contains instructions for setting up queue processing on shared hosting

## For Shared Hosting (cPanel/Plesk/DirectAdmin):

### Option 1: Using Cron Job Manager (Recommended)

1. **Log into your hosting control panel**
2. **Navigate to Cron Jobs section**
3. **Add a new cron job with these settings:**

```
Minute: */5
Hour: *
Day: *
Month: *
Weekday: *
Command: cd /path/to/your/laravel/app && /usr/local/bin/php artisan queue:run-worker --max-jobs=5 --sleep=10
```

### Option 2: Using Command Line (if available)

If you have SSH access, you can also run:

```bash
# Run queue worker for 5 jobs, sleep 10 seconds between each
/usr/local/bin/php /path/to/your/laravel/app/artisan queue:run-worker --max-jobs=5 --sleep=10

# Or run continuously (not recommended for shared hosting)
/usr/local/bin/php /path/to/your/laravel/app/artisan queue:work --tries=3 --timeout=3600
```

## Important Notes:

1. **Path to PHP**: Make sure to use the correct path to PHP binary. Common paths:
   - `/usr/local/bin/php`
   - `/usr/bin/php`
   - `/opt/cpanel/ea-php74/root/usr/bin/php` (for specific PHP versions)

2. **Laravel Path**: Replace `/path/to/your/laravel/app` with the actual path to your Laravel application.

3. **Frequency**: The `*/5` means run every 5 minutes. Adjust based on your needs:
   - `*/2` = every 2 minutes
   - `*/10` = every 10 minutes
   - `0,30` = at minute 0 and 30 (every 30 minutes)

4. **Resource Limits**: Shared hosting has limits, so:
   - Keep `--max-jobs` low (5-10)
   - Use `--sleep` to prevent server overload
   - Monitor your hosting account for resource usage

5. **Logs**: Check your Laravel logs at `storage/logs/laravel.log` for import progress and errors.

## Alternative: Web Cron Services

If your hosting doesn't allow cron jobs, you can use web cron services:

1. **WebCron.org** or **EasyCron.com**
2. **Set up a cron job to call**: `https://yourdomain.com/cron-queue`
3. **Create a route in `routes/web.php`**:

```php
Route::get('/cron-queue', function () {
    Artisan::call('queue:run-worker', ['--max-jobs' => 5, '--sleep' => 10]);
    return 'Queue processed';
});
```

## Monitoring Queue Status

Check queue status with:
```bash
php artisan queue:status
```

View failed jobs:
```bash
php artisan queue:failed
```

Retry failed jobs:
```bash
php artisan queue:retry all
```