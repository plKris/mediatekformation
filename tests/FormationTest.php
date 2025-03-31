<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;


/**
 * Description of FormationTest
 *
 * @author Plese
 */
class FormationTest extends TestCase {
    public function testGetPublishedAtString(){
        $formation = new Formation();
        
        $formation->setPublishedAt(new DateTime("2024-04-24"));
        
        $this->assertEquals("24/04/2024", $formation->getPublishedAtString());
        
    }
}
