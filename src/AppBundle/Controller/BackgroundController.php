<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\{
    Method, Route
};
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{
    Request, Response
};

class BackgroundController extends Controller
{
    /**
     * Check background
     *
     * @Route("/check_bg", name="check_background")
     * @Method("GET")
     *
     */
    public function checkBackgroundAction(Request $request): Response
    {
        $force_change = ($request->get('force_change') === '');

        $file_path = realpath($this->getParameter('public_dir')) . DIRECTORY_SEPARATOR.
            'images' . DIRECTORY_SEPARATOR .
            'background.jpg';
        $file_existed = file_exists($file_path);
        $file = new \SplFileObject($file_path, 'c+');

        $last_modified = (new \DateTime)->setTimestamp($file->getMTime());

        $date = new \DateTime();

        // If the file exists and is up-to-date
        if (!$force_change && $file_existed && ($last_modified->format('d-m') === $date->format('d-m'))) {
            return new Response('0');
        }

        // If there is no file or it is outdated or forcing was used:

        // clear data if file exists
        if ($file_existed) {
            $file->ftruncate(0);
        }

        // Get and write new image
        $content = file_get_contents('https://source.unsplash.com/random');
        $file->fwrite($content);

        return new Response('1');
    }


}
