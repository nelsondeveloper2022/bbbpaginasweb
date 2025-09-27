<?php

if (!function_exists('localized_route')) {
    /**
     * Generate a localized route with the current locale
     */
    function localized_route($name, $parameters = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $parameters = array_merge(['locale' => $locale], $parameters);
        
        return route($name, $parameters);
    }
}

if (!function_exists('switch_locale_url')) {
    /**
     * Generate URL for switching to a different locale
     */
    function switch_locale_url($locale)
    {
        $currentPath = request()->path();
        
        // Remove current locale from path if present
        $segments = explode('/', $currentPath);
        if (in_array($segments[0], ['es', 'en'])) {
            array_shift($segments);
        }
        
        $newPath = $locale . '/' . implode('/', $segments);
        
        return url($newPath);
    }
}

if (!function_exists('clean_plan_description')) {
    /**
     * Clean HTML from plan description and format it for email
     */
    function clean_plan_description($description)
    {
        if (empty($description)) {
            return '';
        }
        
        // Convert HTML list items to bullet points
        $description = preg_replace('/<li[^>]*><i[^>]*><\/i>\s*([^<]+)<\/li>/', '• $1', $description);
        
        // Remove all HTML tags except <br> and <p>
        $description = strip_tags($description, '<br><p>');
        
        // Clean up extra spaces and line breaks
        $description = preg_replace('/\s+/', ' ', $description);
        $description = trim($description);
        
        return $description;
    }
}