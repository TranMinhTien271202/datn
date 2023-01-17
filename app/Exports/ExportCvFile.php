<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCvFile implements FromCollection
{
    public function __construct(int $post_id)
    {
        $this->post_id = $post_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (!empty($this->post_id)) {
            $model = JobPost::with('seekerProfiles')->find($post_id);
            $model->seekerProfiles()->where('is_function',0);
        }
    }
}
