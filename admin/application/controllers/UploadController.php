<?php
/**
 * @author ismd
 */

require APPLICATION_PATH . '/../lib/ImageResize.php';
use \Eventviva\ImageResize;

class UploadController extends AbstractAuthController {

    private $MOB_UPLOAD_PATH;
    private $MOB_UPLOAD_RESIZED_PATH;

    private $NPC_UPLOAD_PATH;
    private $NPC_UPLOAD_RESIZED_PATH;

    public function init() {
        $siteApplicationPath = PsConfig::getInstance()->site->application_path;

        $this->MOB_UPLOAD_PATH         = $siteApplicationPath . '/../public/pictures/mobs';
        $this->MOB_UPLOAD_RESIZED_PATH = $siteApplicationPath . '/../public/pictures/mobs_resized';

        $this->NPC_UPLOAD_PATH         = $siteApplicationPath . '/../public/pictures/npcs';
        $this->NPC_UPLOAD_RESIZED_PATH = $siteApplicationPath . '/../public/pictures/npcs_resized';
    }

    public function mobAction() {
        $this->_upload($this->MOB_UPLOAD_PATH, $this->MOB_UPLOAD_RESIZED_PATH);
    }

    public function npcAction() {
        $this->_upload($this->NPC_UPLOAD_PATH, $this->NPC_UPLOAD_RESIZED_PATH);
    }

    private function _upload($uploadPath, $uploadResizedPath) {
        if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->view->json([
                'status' => 'error',
            ]);
        }

        $microtime  = microtime(true);
        $microtime  = (int)str_replace('.', '', $microtime);
        $microtime /= rand(10000, 100000);
        $microtime  = (int)$microtime;

        $tmpName = $_FILES['image']['tmp_name'];

        // Расширение
        switch ($_FILES['image']['type']) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;

            case 'image/png':
                $extension = 'png';
                break;

            case 'image/gif':
                $extension = 'gif';
                break;

            default:
                $this->view->json([
                    'status' => 'error',
                ]);
                break;
        }

        // Имя файла
        $i = 0;
        do {
            if (100 == $i++) {
                $this->view->json([
                    'status' => 'error',
                ]);

                throw new Exception('Error while uploading file');
            }

            $name = $this->getHelper('generator')->alphaID($microtime);

            if (!file_exists($uploadPath . '/' . $name . '.' . $extension)) {
                break;
            }
        } while (true);

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0700);
        }

        if (!is_dir($uploadResizedPath)) {
            mkdir($uploadResizedPath, 0700);
        }

        move_uploaded_file($tmpName, $uploadPath . '/' . $name . '.' . $extension);
        chmod($uploadPath . '/' . $name . '.' . $extension, 400);

        $this->resizeImage($uploadPath,
            $uploadResizedPath,
            $name,
            $extension);

        $this->view->json([
            'status' => 'ok',
            'image'  => $name . '.' . $extension,
        ]);
    }

    private function resizeImage($path, $resizedPath, $name, $extension) {
        $image = new ImageResize($path . '/' . $name . '.' . $extension);
        $image->crop(120, 120);
        $image->save($resizedPath . '/120x120_' . $name . '.' . $extension);
        chmod($resizedPath . '/120x120_' . $name . '.' . $extension, 400);
    }
}
