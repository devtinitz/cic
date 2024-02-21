<?php

    /**
     * Determine si la configuration s'est terminée
     */

    function setupStatus()
    {
        try {
            $checkComplete = \App\Models\Setting::first();
            if (!$checkComplete) {
                return false;
            }
            if ($checkComplete->setup_complete === '0') {
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Sauvegarde d'image
     */

    function storeImage($image){
        $extension = $image->extension();
        $fileName = date('dmY').'-'.time().'.'.$extension;
        $image->move('images', $fileName);
        $imageUrl = \Illuminate\Support\Facades\URL::to('/images/'.$fileName);
        return $imageUrl;
    }