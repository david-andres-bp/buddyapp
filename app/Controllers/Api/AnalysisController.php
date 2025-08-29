<?php

namespace App\Controllers\Api;

use App\Libraries\AIAnalysis;
use CodeIgniter\RESTful\ResourceController;

class AnalysisController extends ResourceController
{
    /**
     * Analyze content and return personality tags.
     *
     * @return mixed
     */
    public function create()
    {
        $content = $this->request->getJsonVar('content');
        if (empty($content)) {
            return $this->failValidationErrors('Content is required for analysis.');
        }

        $analysis = new AIAnalysis();
        $tags = $analysis->analyzeText($content);

        return $this->respond(['tags' => $tags]);
    }
}
