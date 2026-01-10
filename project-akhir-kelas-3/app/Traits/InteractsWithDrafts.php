<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait InteractsWithDrafts
{
    /**
     * Get the session key for the draft
     */
    protected function getDraftSessionKey(string $prefix): string
    {
        return $prefix . '_draft_' . session()->getId();
    }

    /**
     * Get all drafts for a given prefix
     */
    protected function getDrafts(string $prefix): array
    {
        return session()->get($this->getDraftSessionKey($prefix), []);
    }

    /**
     * Store a new draft item
     */
    protected function storeDraft(string $prefix, array $data): void
    {
        $key = $this->getDraftSessionKey($prefix);
        $drafts = session()->get($key, []);
        
        $data['id'] = $data['id'] ?? uniqid($prefix . '_');
        $data['created_at'] = $data['created_at'] ?? now()->toDateTimeString();
        
        $drafts[] = $data;
        session()->put($key, $drafts);
    }

    /**
     * Update an existing draft item
     */
    protected function updateDraft(string $prefix, string $id, array $data): bool
    {
        $key = $this->getDraftSessionKey($prefix);
        $drafts = session()->get($key, []);
        $updated = false;

        $drafts = collect($drafts)->map(function ($item) use ($id, $data, &$updated) {
            if ($item['id'] === $id) {
                $updated = true;
                return array_merge($item, $data, [
                    'updated_at' => now()->toDateTimeString()
                ]);
            }
            return $item;
        })->all();

        if ($updated) {
            session()->put($key, $drafts);
        }

        return $updated;
    }

    /**
     * Delete a draft item
     */
    protected function deleteDraft(string $prefix, string $id): void
    {
        $key = $this->getDraftSessionKey($prefix);
        $drafts = session()->get($key, []);

        $drafts = collect($drafts)->reject(function ($item) use ($id) {
            return $item['id'] === $id;
        })->values()->all();

        session()->put($key, $drafts);
    }

    /**
     * Clear all drafts for a prefix
     */
    protected function clearDrafts(string $prefix): void
    {
        session()->forget($this->getDraftSessionKey($prefix));
    }

    /**
     * Find a single draft item by ID
     */
    protected function findDraft(string $prefix, string $id): ?array
    {
        return collect($this->getDrafts($prefix))->firstWhere('id', $id);
    }
}
