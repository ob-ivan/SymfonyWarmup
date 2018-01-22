<?php
namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/databases")
     */
    public function databases(Connection $conn)
    {
        $stmt = $conn->query("SHOW DATABASES");
        $databases = [];
        while ($row = $stmt->fetch()) {
            $databases[] = print_r($row, true);
        }
        return $this->render('lucky/databases.html.twig', [
            'databases' => $databases,
        ]);
    }

    /**
     * @Route("/lucky/number")
     */
    public function number()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}
