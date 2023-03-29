<?php

namespace App\Http\Controllers;

use Dcs\Ref\Models\RefCommune;
use App\Models\EnteteCommune;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use PDF;
use App;

class EnteteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function entete_page($commune)
    {
        $style = '';

        $html = '';
        $lib_wilaya_ar = ' ولاية ' . $commune->moughataa->wilaya->libelle_ar;
        $lib_wilaya = "Wilaya de " . $commune->moughataa->wilaya->libelle;
        $lib_moughataa_ar = ' مقاطعة ' . $commune->moughataa->libelle_ar;
        $lib_moughataa = "Moughataa de " . $commune->moughataa->libelle;
        $lib_commune_ar = ' بلدية ' . $commune->libelle_ar;
        $lib_commune = ' Commune de ' . $commune->libelle;
        $header =
            <<<ODE
                <table >
                    <tr>
                        <td width="100%" dir="ltr">
                            <img src="img/pdf_header.png" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" width="30%">
                            <b><span>$lib_wilaya_ar</span></b><br>
                            <b><span>$lib_wilaya</b></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" width="30%">
                            <b><span>$lib_moughataa_ar</b></span><br>
                            <b><span>$lib_moughataa</b></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" width="30%">
                           <b> <span>$lib_commune_ar</b></span><br>
                           <b> <span>$lib_commune</b></span>
                        </td>
                    </tr>

                </table>
            ODE;

        $html .= $header;

        return $html;
    }

    public function entete_page1($commune)
    {
        $style = '';

        $html = <<<EOD
            <style>
               td.entete
              {
                font-size: 8px;
                font-weight: bold;
                text-align: center;
                width: 25%;
             }
            img {
                height: 80px; width: 100%;
            }
            </style>
  EOD;
        $lib_wilaya_ar = ' ولاية ' . $commune->moughataa->wilaya->libelle_ar;
        $lib_wilaya = "Wilaya de " . $commune->moughataa->wilaya->libelle;
        $lib_moughataa_ar = ' مقاطعة ' . $commune->moughataa->libelle_ar;
        $lib_moughataa = "Moughataa de " . $commune->moughataa->libelle;
        $lib_commune_ar = ' بلدية ' . $commune->libelle_ar;
        $lib_commune = ' Commune de ' . $commune->libelle;
        if (App::isLocale('ar')) {
            $header =
                <<<ODE
                <table width="100%">
                       <tr>
                            <td class="entete"></td>
                            <td class="entete"></td>
                            <td class="entete"></td>
                            <td class="entete">
                            <b><span>$lib_wilaya_ar</span></b><br>
                            <b><span>$lib_wilaya</b></span>
                        </td>
                    </tr>
                    <tr>
                             <td class="entete"></td>
                             <td class="entete"></td>
                             <td class="entete"></td>
                             <td class="entete">
                             <b><span>$lib_moughataa_ar</b></span><br>
                             <b><span>$lib_moughataa</b></span>
                            </td>
                    </tr>
                    <tr>

                                <td class="entete"></td>
                                <td class="entete"></td>
                                <td class="entete"></td>
                                <td class="entete">
                                 <b> <span>$lib_commune_ar</b></span><br>
                                 <b> <span>$lib_commune</b></span>
                                </td>
                         </tr>

                </table>
            ODE;
        } else {
               $header =
                <<<ODE
                <table width="100%">
                       <tr>

                            <td class="entete">
                              <b><span>$lib_wilaya_ar</span></b><br>
                              <b><span>$lib_wilaya</b></span>
                           </td>
                             <td class="entete"></td>
                            <td class="entete"></td>
                            <td class="entete"></td>
                    </tr>
                    <tr>

                             <td class="entete">
                              <b><span>$lib_moughataa_ar</b></span><br>
                              <b><span>$lib_moughataa</b></span>
                            </td>
                            <td class="entete"></td>
                            <td class="entete"></td>
                            <td class="entete"></td>
                    </tr>
                    <tr>

                                <td class="entete">
                                  <b> <span>$lib_commune_ar</b></span><br>
                                  <b> <span>$lib_commune</b></span>
                                </td>
                                <td class="entete"></td>
                                <td class="entete"></td>
                                <td class="entete"></td>
                         </tr>

                </table>
            ODE;
        }


        $html .= $header;

        //dd($html);
        return $html;
    }

    public function entete($id_commune)
    {
        /* $commune = Commune::find($id_commune);
         $img = 'img/teyaret.png';
         //$ext = \File::extension($img);
         $html = $this->entete_page(
             'ولاية انواكشوط الغربية',
             'مقاطعة تيارت',
             'بلدية تيارت',
             'willaya nouakchott nord',
             'Moughataa de Teyarett',
             'Commune de Teyarett');

         $pdf = new TCPDF();

         $pdf->SetFont('dejavusans', '', 8);
         $pdf->SetTitle('Entete');
         $pdf->AddPage();
         $pdf->writeHTML($html, true, false, true, false, '');
         $pdf->Image($img, 90, 10, 18, 18, $ext, '', '', false, 150, '', false, false, 0, false, false, false);
         $pdf->Output(uniqid('entete_') . '.pdf');*/

//        return $html;
    }

    public function logo_commune($img = false)
    {
        if ($img == false)
            $img = env("LOGO_COMMUNE");

        //  $logo = url('img/'+$img);
        $ext = \File::extension($img);

        PDF::Image($img, 90, 10, 18, 18, $ext, '', '', false, 150, '', false, false, 0, false, false, false);
        //$pdf->Output(uniqid('entete_') . '.pdf');

//        return $html;
    }

    public function logo($pdf=false,$img=false)
    {

        // logo officiel
            $img_log ="img/pdf_header.png";
        //  $logo = url('img/'+$img);
        $ext_log = \File::extension($img_log);

        PDF::Image($img_log, 10, 10, 200, 20, $ext_log, '', '', false, 40, '', false, false, 0, false, false, false);

        // logo communes
        if ($img == false)
            $img = env("LOGO_COMMUNE");

        //  $logo = url('img/'+$img);
        $ext = \File::extension($img);

        PDF::Image($img, 90, 10, 18, 18, $ext, '', '', false, 150, '', false, false, 0, false, false, false);

    }
    public function logo_commune1($mpdf, $img = false)
    {
        if ($img == false)
            $img = env("LOGO_COMMUNE");

        //  $logo = url('img/'+$img);
        $ext = \File::extension($img);

        $mpdf->Image($img, 90, 10, 18, 18, $ext, '', true, false);
        // $mpdf->Image('files/images/frontcover.jpg', 0, 0, 210, 297, 'jpg', '', true, false);
        //$pdf->Output(uniqid('entete_') . '.pdf');

//        return $html;
    }

    public function logo_commune2($mpdf, $img = false)
    {
        if ($img == false)
            $img = env("LOGO_COMMUNE");

        //  $logo = url('img/'+$img);
        $ext = \File::extension($img);

        $mpdf->Image($img, 85, 5, 18, 18, $ext, '', true, false);
        // $mpdf->Image('files/images/frontcover.jpg', 0, 0, 210, 297, 'jpg', '', true, false);
        //$pdf->Output(uniqid('entete_') . '.pdf');

//        return $html;
    }
}
