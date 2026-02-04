<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAuthorBooksCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $authorId;

    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    public function handle(): void
    {
        $count = Book::where('author_id', $this->authorId)->count();

        Author::where('id', $this->authorId)
            ->update(['books_count' => $count]);
    }
}
