<?php
/**
 * Тест класса Character
 * @author ismd
 */

class CharacterTest extends PHPUnit_Framework_TestCase {

    public function provider() {
        return array(
            array(
                array(
                    'id'         => 123,
                    'idUser'     => 234,
                    'name'       => 'my name',
                    'level'      => 32,
                    'money'      => 111,
                    'hp'         => 345,
                    'maxHp'      => 456,
                    'minDamage'  => 567,
                    'maxDamage'  => 678,
                    'experience' => 789,
                    'image'      => 'image.png',
                    'strength'   => 11,
                    'dexterity'  => 12,
                    'endurance'  => 13,
                    'idMap'      => 333,
                ),
            ), array(
                array(
                    'id'         => 1,
                    'idUser'     => 1,
                    'name'       => 'my name',
                    'level'      => 1,
                    'money'      => 100,
                    'hp'         => 55,
                    'maxHp'      => 100,
                    'minDamage'  => 1,
                    'maxDamage'  => 3,
                    'experience' => 10,
                    'image'      => 'player.png',
                    'strength'   => 10,
                    'dexterity'  => 7,
                    'endurance'  => 8,
                    'idMap'      => 1,
                ),
            ),
        );
    }

    /**
     * @dataProvider provider
     */
    public function testCharacter($options) {
        $character = new Character($options);

        $character->cell = new Cell(new Map(array(
            'id'    => $options['idMap'],
            'title' => 'test map',
        )), 334, 335);

        $this->assertEquals(array_merge($options, array(
            'x' => 334,
            'y' => 335,
        )), $character->toArray());
    }
}
