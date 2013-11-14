<?php
/**
 * Контроллер персонажа
 * @author ismd
 */

class CharacterController extends PsAuthController {

    public function createPartial() {
    }

    /**
     * Создание персонажа
     */
    public function createAction() {
        $post = $this->getRequest()->getPost();
        PsLogger::getInstance()->log($post);
        $character = new Character([
            'user' => $this->getSession()->user,
            'name' => $post->name,
        ]);

        // Устанавливаем начальные значения
        $character->setDefaultValues();

        try {
            $mapper = CharacterMapper::getInstance();
            $id = $mapper->save($character);

            // Добавляем созданного персонажа в список персонажей пользователя
            $this->getSession()->user->setCharacters(array_merge(
                $this->getSession()->user->getCharacters(),
                [$mapper->getById($id)]
            ));

            $this->view->json([
                'status'  => 'ok',
                'message' => '',
                'id'      => $id,
            ]);
        } catch (CharacterLongNameException $e) {
            $this->view->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        } catch (CharacterShortNameException $e) {
            $this->view->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        } catch (CharacterNameExistsException $e) {
            $this->view->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            $this->view->json([
                'status'  => 'error',
                'message' => 'Ошибка',
            ]);
        }
    }
}
