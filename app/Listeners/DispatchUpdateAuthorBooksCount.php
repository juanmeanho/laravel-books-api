<?php

namespace App\Listeners;

use App\Events\BookCreated;
use App\Jobs\UpdateAuthorBooksCountJob;

class DispatchUpdateAuthorBooksCount
{
    public function handle(BookCreated $event): void
    {
        UpdateAuthorBooksCountJob::dispatch(
            $event->book->author_id
        );
    }
}
