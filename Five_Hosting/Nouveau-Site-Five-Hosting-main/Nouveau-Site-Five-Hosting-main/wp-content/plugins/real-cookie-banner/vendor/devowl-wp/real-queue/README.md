# `@devowl-wp/real-queue`

Provide a promise-based queue system working in frontend for client and server tasks.

## Example

```php
<?php
class MyExampleExecutor
{
    public static function execute(Job $job)
    {
        // Do something or throw an Exception
    }
}

$queue = Core::instance();

$persist = $queue->getPersist();
$persist->startTransaction();

// Optional: Bundle this jobs together in an own group
$persist->startGroup();

$job = new Job($queue);
$job->type = "example";
$job->data = new stdClass();
$job->data->example = 1;
$job->retries = 3;
$job->callable = [MyExampleExecutor::class, "execute"];
$persist->addJob($job);

$job = new Job($queue);
$job->type = "example";
$job->data = new stdClass();
$job->data->example = 2;
$job->retries = 3;
$job->callable = [MyExampleExecutor::class, "execute"];
$persist->addJob($job);

$persist->stopGroup();

$job = new Job($queue);
$job->type = "example";
$job->data = new stdClass();
$job->data->example = "test";
$job->retries = 3;
$job->callable = [MyExampleExecutor::class, "execute"];
$persist->addJob($job);

$persist->commit();
```

## Client-worker

tbd;
