<?php

/**
 * Created by PhpStorm.
 * User: aoen
 * Date: 15.02.17
 * Time: 14:53
 */
class Boat
{
    public $Name;
    public $SailNumber;

    public $VLM = 0;//высота грота - как вычислить из измерений паруса
    public $VLJ = 0;//высота стаксели - так же как и выше

    public $WL=0,$AL=0;//длина по ватерлинии, длина полная

    public $WS=0,$WC=0;//вес лодки, вес экипажа

    public $crew=1;//количество члено команды

    public $mast;
    public $sails = array(
        'Main'=>'',
        'Jib' =>'',
        'Spinaker'=>''
    );

    public function __construct()
    {
        $this->mast = new Mast();
        foreach ($this->sails as $key=>$sail){
            if($key == 'Spinaker'){
                $this->sails[$key] = new Spinaker();
            }else {
                $this->sails[$key] = new Sail();
            }
        }
    }

    public function solveGB(){

        $this->mast->P = $this->sails['Main']->P;

        $L = $this->AL;
        $W = $this->WC+$this->WS;
        $XM= $this->sails['Main']->P == 0 ? 0 : pow($this->sails['Main']->P,2) / ($this->sails['Main']->getSquare() + $this->mast->getSquare());
        $XJ= $this->sails['Jib']->VLM == 0 ? 0 : pow($this->sails['Jib']->VLM,2) / $this->sails['Jib']->getSquare();
        $ME= 40.1+18.31 * $XM - 2.016 * pow($XM,2) + 0.07472 * pow($XM,3);
        $MJ= 40.1+18.31 * $XJ - 2.016 * pow($XJ,2) + 0.07472 * pow($XJ,3);
        $M = ($this->sails['Main']->getSquare() + $this->mast->getSquare()) * $ME / 100;
        $J = $this->sails['Jib']->getSquare() * $MJ / 100 + ($this->sails['Spinaker']->getSquare() == 0 ? 0 : 0.1*($this->sails['Spinaker']->getSquare() - $this->sails['Jib']->getSquare()));
        //$J = $this->sails['Jib']->VLM * $MJ / 100 + $this->sails['Spinaker']->getSquare() == 0 ? 0 : 0.1*($this->sails['Spinaker']->getSquare() - $this->sails['Jib']->getSquare());
        $A = $M + $J;
        $ZM2 = sqrt($W*$L)/$A;
        $DLR = $W/pow($L,3);
        $XC4 = 1 + (0.0061012 * $ZM2 * $L * $DLR);
        $XC2 = 0.4556343 - (0.473292*$ZM2 * (1.038881 + (0.4371713 * $DLR)));
        $XC = (-0.0414213+(-2.554547*$ZM2/$L)+(0.00132305 * $ZM2 * pow($L,2)));
        $VT_VB = sqrt((-$XC2 + sqrt(pow($XC2,2) - 4 * $XC4 * $XC)) / (2 * $XC4));
        return 1.25/$VT_VB;
    }
}

interface Square{
    function getSquare();
}

interface SailTemplate{
    public function getTemplate();
}

class Sail implements Square,SailTemplate {

    public $P =0 ,$B=0 ,$E=0 ,$HP=0 ,$HB=0 ,$HE=0 ,$VLM=0;
    public $SailPrefix = '';
    function getSquare()
    {
        $r = ($this->P + $this->B + $this->E)/2;
        $S1 = sqrt( $r * ($r - $this->P) * ($r - $this->B) * ($r - $this->E) );
        return $S1 + (2/3 * $this->HP * $this->P) + (2/3 * $this->B * $this->HB) + (2/3 * $this->E * $this->HE);
    }

    public function getTemplate()
    {
        $SailPrefix = $this->SailPrefix;
        if($SailPrefix == ''){
            $SailPrefix=SailSupport::generateRandomVar();
            $this->SailPrefix=$SailPrefix;
        }
        $Result = "<div class=\"sail\" id=\"".$SailPrefix."Main\">
        <table class=\"sailTable\">
            <tr class=\"sailTable\">
                <td class=\"sailTable\">
                    <ul>
                        <li>P<input id=\"".$SailPrefix."P\" class=\"".$SailPrefix."MainVal\" /></li>
                        <li>HP<input id=\"".$SailPrefix."HP\" class=\"".$SailPrefix."MainVal\" /></li>
                        <li>B<input id=\"".$SailPrefix."B\" class=\"".$SailPrefix."MainVal\" /></li>
                        <li>HB<input id=\"".$SailPrefix."HB\" class=\"".$SailPrefix."MainVal\" /></li>
                        <li>E<input id=\"".$SailPrefix."E\" class=\"".$SailPrefix."MainVal\" /></li>
                        <li>HE<input id=\"".$SailPrefix."HE\" class=\"".$SailPrefix."MainVal\" /></li>
                    </ul>
                </td>
                <td>
                    <div class=\"sail\" id=\"".$SailPrefix."MainSVG\"></div>
                </td>
            </tr>
        </table>

        </div>
        
        <script>

       

    $(\".".$SailPrefix."MainVal\").change(function () {

        $('#".$SailPrefix."MainSVG').empty();

        var draw = SVG('".$SailPrefix."MainSVG').size(300,300);

        var ".$SailPrefix."P = parseFloat(document.getElementById('".$SailPrefix."P').value);
        var ".$SailPrefix."B = parseFloat(document.getElementById('".$SailPrefix."B').value);
        var ".$SailPrefix."E = parseFloat(document.getElementById('".$SailPrefix."E').value);
        var ".$SailPrefix."HP = parseFloat(document.getElementById('".$SailPrefix."HP').value);
        var ".$SailPrefix."HB = parseFloat(document.getElementById('".$SailPrefix."HB').value);
        var ".$SailPrefix."HE = parseFloat(document.getElementById('".$SailPrefix."HE').value);

        var ".$SailPrefix."maxWidth = ".$SailPrefix."HP > 0 ? ".$SailPrefix."HP : 0 + ".$SailPrefix."E;
        var ".$SailPrefix."maxHeight= ".$SailPrefix."HE > 0 ? ".$SailPrefix."HE : 0 + ".$SailPrefix."P;


        var ".$SailPrefix."baseX = ".$SailPrefix."HP > 0 ? ".$SailPrefix."HP : 0;
        var ".$SailPrefix."baseY = ".$SailPrefix."HE > 0 ? ".$SailPrefix."HE : 0;

        var ".$SailPrefix."Hh = $('#".$SailPrefix."MainSVG').height()-5;
        var ".$SailPrefix."Hw = $('#".$SailPrefix."MainSVG').width()-3;

        var ".$SailPrefix."k =  ".$SailPrefix."Hh / ( Math.max( (isNaN(".$SailPrefix."P)?0:".$SailPrefix."P),  Math.max( (isNaN(".$SailPrefix."E) ? 0:".$SailPrefix."E),(isNaN(".$SailPrefix."B) ? 0 : ".$SailPrefix."B))  )  );

        if(isNaN(".$SailPrefix."HP)) ".$SailPrefix."HP = 0;
        if(isNaN(".$SailPrefix."HB)) ".$SailPrefix."HB = 0;
        if(isNaN(".$SailPrefix."HE)) ".$SailPrefix."HE = 0;

        if(!isNaN(".$SailPrefix."P)){

            var ".$SailPrefix."pAx = (".$SailPrefix."HP > 0 ? (".$SailPrefix."HP * ".$SailPrefix."k) : 0);
            var ".$SailPrefix."pAy = ".$SailPrefix."Hh - (".$SailPrefix."HE > 0 ? (".$SailPrefix."HE * ".$SailPrefix."k) : 0);

            var ".$SailPrefix."pBx = 0; //завжди 0
            var ".$SailPrefix."pBy = ".$SailPrefix."Hh / 2 - (".$SailPrefix."HE > 0 ? (".$SailPrefix."HE * ".$SailPrefix."k) : 0);

            var ".$SailPrefix."pCx = ".$SailPrefix."pAx;
            var ".$SailPrefix."pCy = 0;

        }
        var ".$SailPrefix."AB = draw.line(".$SailPrefix."pAx,".$SailPrefix."pAy,".$SailPrefix."pBx,".$SailPrefix."pBy).stroke({width:1 , color:'#ff162a' });
        var ".$SailPrefix."BC = draw.line(".$SailPrefix."pBx,".$SailPrefix."pBy,".$SailPrefix."pCx,".$SailPrefix."pCy).stroke({width:1 , color:'#111bff' });
        var ".$SailPrefix."AC = draw.line(".$SailPrefix."pAx,".$SailPrefix."pAy,".$SailPrefix."pCx,".$SailPrefix."pCy).stroke({width:1 , color:'#111bff' });


        if(!isNaN(".$SailPrefix."E)){
            //так начебто в другий раз рахуємо
            var ".$SailPrefix."pAx = (".$SailPrefix."HP > 0 ? (".$SailPrefix."HP * ".$SailPrefix."k) : 0);
            var ".$SailPrefix."pAy = ".$SailPrefix."Hh - (".$SailPrefix."HE > 0 ? (".$SailPrefix."HE * ".$SailPrefix."k) : 0);

            var ".$SailPrefix."pEx = ".$SailPrefix."Hw  - (".$SailPrefix."HP > 0 ? ".$SailPrefix."HP : 0);
            var ".$SailPrefix."pEy =".$SailPrefix."pAy;

            var ".$SailPrefix."pFx = ".$SailPrefix."Hw / 2  - (".$SailPrefix."HP > 0 ? ".$SailPrefix."HP * ".$SailPrefix."k : 0);
            var ".$SailPrefix."pFy = ".$SailPrefix."Hh + (".$SailPrefix."HE < 0 ? ".$SailPrefix."HE * ".$SailPrefix."k: 0);

            var ".$SailPrefix."AF = draw.line(".$SailPrefix."pAx,".$SailPrefix."pAy,".$SailPrefix."pFx,".$SailPrefix."pFy).stroke({width:1 , color:'#111bff' });
            var ".$SailPrefix."FE = draw.line(".$SailPrefix."pFx,".$SailPrefix."pFy,".$SailPrefix."pEx,".$SailPrefix."pEy).stroke({width:1 , color:'#111bff' });
            var ".$SailPrefix."AE = draw.line(".$SailPrefix."pAx,".$SailPrefix."pAy,".$SailPrefix."pEx,".$SailPrefix."pEy).stroke({width:1 , color:'#ff162a' });
        }

        if(!isNaN(".$SailPrefix."B)){

            var ".$SailPrefix."pCx = (".$SailPrefix."HP > 0 ? (".$SailPrefix."HP * ".$SailPrefix."k) : 0);
            var ".$SailPrefix."pCy = 0;

            var ".$SailPrefix."pEx = ".$SailPrefix."Hw  - (".$SailPrefix."HP > 0 ? ".$SailPrefix."HP : 0);
            var ".$SailPrefix."pEy = ".$SailPrefix."Hh - (".$SailPrefix."HE > 0 ? (".$SailPrefix."HE * ".$SailPrefix."k) : 0);

            var ".$SailPrefix."pDx =  (".$SailPrefix."pEx-".$SailPrefix."pCx)/2 + (".$SailPrefix."HB * ".$SailPrefix."k);
            var ".$SailPrefix."pDy = (".$SailPrefix."Hh / 2 - (".$SailPrefix."HE > 0 ? (".$SailPrefix."HE * ".$SailPrefix."k) : 0));

            var ".$SailPrefix."CD = draw.line(".$SailPrefix."pCx,".$SailPrefix."pCy,".$SailPrefix."pDx,".$SailPrefix."pDy).stroke({width:1 , color:'#111bff' });
            var ".$SailPrefix."DE = draw.line(".$SailPrefix."pDx,".$SailPrefix."pDy,".$SailPrefix."pEx,".$SailPrefix."pEy).stroke({width:1 , color:'#111bff' });
            var ".$SailPrefix."CE = draw.line(".$SailPrefix."pCx,".$SailPrefix."pCy,".$SailPrefix."pEx,".$SailPrefix."pEy).stroke({width:1 , color:'#ff162a' });

        }

    })
</script>
        ";

return $Result;
    }
}

class Mast implements Square,SailTemplate {

    public $P = 0, $D1 =0, $D=0, $d=0;
    public $SailPrefix = '';
    function getSquare()
    {
        return $this->P * ($this->D1 - $this->D - $this->d);
    }

    public function getTemplate($SailPrefix = '')
    {
        $SailPrefix = $this->SailPrefix;
        if($SailPrefix == ''){
            $SailPrefix=SailSupport::generateRandomVar();
            $this->SailPrefix=$SailPrefix;
        }
        return "<div class=\"sail\" id=\"".$SailPrefix."Must\">
        <table class=\"sailTable\">
            <tr class=\"sailTable\">
                <td class=\"sailTable\">
                    <ul>
                        <li>P<input id=\"".$SailPrefix."DP\" class=\"MustVal\" /></li>
                        <li>D<input id=\"".$SailPrefix."DD\" class=\"MustVal\" /></li>
                        <li>D1<input id=\"".$SailPrefix."D1\" class=\"MustVal\" /></li>
                        <li>d<input id=\"".$SailPrefix."dl\" class=\"MustVal\" /></li>
                    </ul>
                </td>
                <td>
                    <div class=\"sail\" id=\"".$SailPrefix."MustSVG\"></div>
                </td>
            </tr>
        </table>
        </div>
        <script>
            $(\".".$SailPrefix."MustVal\").change(function () {
        $('#".$SailPrefix."MustSVG').empty();

        var ".$SailPrefix."D = parseFloat(document.getElementById('".$SailPrefix."DD').value);
        var ".$SailPrefix."D1= parseFloat(document.getElementById('".$SailPrefix."D1').value);
        var ".$SailPrefix."dl = parseFloat(document.getElementById('".$SailPrefix."dl').value);

        var ".$SailPrefix."maxR = Math.max( (isNaN(".$SailPrefix."D)?0:".$SailPrefix."D),(isNaN(".$SailPrefix."D1)?0:".$SailPrefix."D1) );
        var ".$SailPrefix."minR = Math.min( (isNaN(".$SailPrefix."D)?999999999999:".$SailPrefix."D),(isNaN(".$SailPrefix."D1)?999999999999:".$SailPrefix."D1) );
        ".$SailPrefix."dl = isNaN(".$SailPrefix."dl) ? 0 : ".$SailPrefix."dl;

        var ".$SailPrefix."drawMust = SVG('".$SailPrefix."MustSVG').size(".$SailPrefix."maxR+".$SailPrefix."dl,".$SailPrefix."minR);

        var ".$SailPrefix."mMust = drawMust.ellipse(".$SailPrefix."maxR,".$SailPrefix."minR).fill('None').stroke({width:1 , color:'#ff162a' }).x(".$SailPrefix."dl);
        var ".$SailPrefix."litcross=drawMust.circle(".$SailPrefix."dl).fill('None').stroke({width:1 , color:'#111bff' }).dy(((".$SailPrefix."minR-".$SailPrefix."dl)/2) );
    })
        </script>
        ";
    }
}

class Spinaker extends Sail{

    function getSquare()
    {
        $r = ($this->P + $this->B + $this->E);
        return pow($r,2)/16;
    }

    public function getTemplate($SailPrefix = '')
    {
        $SailPrefix = $this->SailPrefix;
        if($SailPrefix == ''){
            $SailPrefix=SailSupport::generateRandomVar();
            $this->SailPrefix=$SailPrefix;
        }
        return 'Ooops I still in proccess...';// TODO: Change the autogenerated stub
    }
}

class SailSupport{

    public static function generateRandomVar($length = 8){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ_';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}