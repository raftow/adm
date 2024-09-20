<?php
$NOM_SITE["ar"] = 'ادارة أعمال القبول';
$NOM_SITE["en"] = 'Admissions management';
$NOM_SITE["fr"] = 'Admissions management';
class x
{
   

   

   

   

   

   

   

   

  

   

   

   

   

   


   

   

   

   

   

   
   

   // application_plan 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 428;
      if ($currstep == 2) return 429;
      if ($currstep == 3) return 432;
      if ($currstep == 4) return 433;

      return 0;
   }

   // application_plan_branch 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 430;
      if ($currstep == 2) return 431;

      return 0;
   }

   

   // check_method 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 447;
      if ($currstep == 2) return 448;

      return 0;
   }

   // check_type 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 445;
      if ($currstep == 2) return 446;

      return 0;
   }

   

   // degree 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 386;
      if ($currstep == 2) return 387;

      return 0;
   }

   // department 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 390;
      if ($currstep == 2) return 391;

      return 0;
   }

   

   // institution 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 400;
      if ($currstep == 2) return 401;

      return 0;
   }

   // major 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 388;
      if ($currstep == 2) return 389;

      return 0;
   }

   

   // major_department 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 392;
      if ($currstep == 2) return 393;

      return 0;
   }

   

   // program_track 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 406;
      if ($currstep == 2) return 407;

      return 0;
   }

   // qualification 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 454;
      if ($currstep == 2) return 455;

      return 0;
   }

   

   // training_unit 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 396;
      if ($currstep == 2) return 397;
      if ($currstep == 3) return 411;
      if ($currstep == 4) return 420;
      if ($currstep == 5) return 421;

      return 0;
   }

   // training_unit_college 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 404;
      if ($currstep == 2) return 405;

      return 0;
   }

   // training_unit_department 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 398;
      if ($currstep == 2) return 399;

      return 0;
   }

   // training_unit_type 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 394;
      if ($currstep == 2) return 395;

      return 0;
   }
}
