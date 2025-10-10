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

if (!function_exists('format_cop_price')) {
    /**
     * Format price in Colombian Pesos (COP) without decimals
     */
    function format_cop_price($price, $includeSymbol = true)
    {
        if (!is_numeric($price)) {
            return $includeSymbol ? '$0' : '0';
        }
        
        $formatted = number_format($price, 0, ',', '.');
        
        return $includeSymbol ? '$' . $formatted : $formatted;
    }
}

if (!function_exists('format_usd_price')) {
    /**
     * Format price in US Dollars (USD) with 2 decimals
     */
    function format_usd_price($price, $includeSymbol = true)
    {
        if (!is_numeric($price)) {
            return $includeSymbol ? '$0.00' : '0.00';
        }
        
        $formatted = number_format($price, 2, '.', ',');
        
        return $includeSymbol ? '$' . $formatted : $formatted;
    }
}

if (!function_exists('format_colombian_date')) {
    /**
     * Format date in Colombian format (dd/mm/yyyy)
     */
    function format_colombian_date($date, $includeTime = false)
    {
        if (!$date) {
            return '';
        }
        
        try {
            $carbonDate = \Carbon\Carbon::parse($date);
            $carbonDate->setTimezone('America/Bogota');
            
            return $includeTime 
                ? $carbonDate->format('d/m/Y H:i')
                : $carbonDate->format('d/m/Y');
        } catch (\Exception $e) {
            return '';
        }
    }
}

if (!function_exists('format_colombian_datetime')) {
    /**
     * Format datetime in Colombian format with timezone
     */
    function format_colombian_datetime($date)
    {
        return format_colombian_date($date, true);
    }
}