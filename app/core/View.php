<?php

namespace App\Core;

use Exception;

class  View
{
    /**
     * Method for load view file dynamically
     *
     * @param string $file
     * @param array $params
     * @return void
     */
    public function view(string $file, array $params = array())
    {
        $viewFile = $this->getFilepath($file);

        if (file_exists($viewFile)) {
            extract($params);

            ob_start();
            require $viewFile;
            $viewContent = ob_get_clean();

            if ($layoutFile ?? '') {
                $this->loadTemplate($layoutFile ?? '', array_merge($params, ['viewContent' => $viewContent]));
            } else {
                echo $viewContent;
            }

            // if isset any previous session clear them
            if (isset($_SESSION['error'])) unset($_SESSION['error']);
            if (isset($_SESSION['old'])) unset($_SESSION['old']);
        } else {
            throw new Exception("View file $viewFile not found!");
        }
    }

    /**
     * Method to load template file
     *
     * @param string $templateName
     * @param array $params
     * @return void
     */
    private function loadTemplate(string $templateName, array $params = [])
    {
        $templateFile = $this->getFilepath($templateName);

        if (!file_exists($templateFile)) {
            throw new Exception("Template file $templateFile not found!");
        }

        extract($params);

        require $templateFile;
    }

    /**
     * Get filepath from filename param
     *
     * @param string $file
     * @return string
     */
    private function getFilepath(string $file): string
    {
        // rerplace all . with /
        $file = str_replace('.', '/', $file);

        return BASE_PATH . "views/$file.view.php";
    }
}
