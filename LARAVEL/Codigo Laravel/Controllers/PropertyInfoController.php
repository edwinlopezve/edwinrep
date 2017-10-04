<?php
/**
 * Controller para vista en detalle
 */
namespace App\Http\Controllers;
use App\Models\Poblacion;
use App\Models\Propiedad;
use App\Models\Provincia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


/**
 * Controlador para gestionar las vistas en detalle de una propiedad. Este controlador no gestiona los items en los
 * listados de destacados o en las busquedas, solo la vista detalla que se accesa por de las URLs de tipo
 * /{province}/{town}/{refprop_id}
 * Class PropertyInfoController
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 * @package App\Http\Controllers
 */
class PropertyInfoController extends Controller{

    /**
     * Retorna la propiedad que existe en la tabla de propiedades y esta identeficadad por ref_code, la comparación
     * se efectua contra la columna ref
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0.
     * @see Propiedad Propiedad
     * @param $ref_code string Código de referencia de la propiedad Actual
     * @return Propiedad Retorna propiedad que sera vista en detalle
     */
    private function getProperty($ref_code){
        return Propiedad::where('ref', $ref_code)->first();
    }

    /**
     * Retorna 4 propiedades del mismo tipo de la propiedad que se esta viendo en detalle
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param string $type Tipo de propiedad a buscar
     * @see Propiedad Propiedad
     * @return mixed
     */
    private function getOthers($type){
        $propiedades = Propiedad::where('type', 'like', $type)->inRandomOrder()->take(4)->get();
        return $propiedades;
    }

    /**
     * Genera la URL para una provicia en particular, siguiendo los patrones SEO establecidos
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Poblacion Poblaciónes
     * @see Provincia Provincias
     * @param $province string Nombre de la provincia
     * @return string retorna la URL para obtener las propiedades de una provincia en particular
     */
    private function generateLinkProvince($province){
        $title = str_replace('-', ' ', $province);
        return "<li><a href='" . url('/' . $this->lang . '/' . $province) . "'>" . ucwords($title) . "</a>></li>";
    }

    /**
     * Genera la URL para una población en particular, siguiendo los patrones SEO establecidos
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Poblacion Poblaciónes
     * @see Provincia Provincia
     * @param $province string Nombre de la provincia
     * @param $location string Nombre de la población
     * @return string retorna la URL para obtener las propiedades de una población en particular
     */
    private function generateLinkLocation($province, $location){
        $title = str_replace('-', ' ', $location);
        return "<li><a href='" . url('/' . $this->lang . '/' . $province . '/'. $location) . "'>" . ucwords($title) . "</a>></li>";
    }

    /**
     * Retorna la vista en detalle que sera servida para una publicación definida por
     * {province}/{poblacion}/{propiedad}. Se toma en consideración si la provincia, población existen, asi como
     * el formato del campo de referencia usado, que puede ser {w} ó {w}-{w}. El layout utilzado se encuentra ubicado
     * en /resources/views/property_info.blade.php; va vista contiene adicional al layout otros parametros que son:
     * <ul>
     *      <li>$propiedad: La propiedad que sera vista en detalle</li>
     *      <li>$otros: 4 propiedades relacionadas a la propiedad actual</li>
     *      <li>$controller: El objeto gestor actual que se encarga de generar el breadcrum y determinar el idioma actual</li>
     * </ul>
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param Request $request
     * @param $province string
     * @param $poblacion string
     * @param $propiedad string
     * @return View Retorna la vista en detalle que sera servida para una publicación definida por
     * {province}/{poblacion}/{propiedad}
     */
    public function index(Request $request, $province, $poblacion, $propiedad){
        $this->lang = substr($request->route()->uri, 0, 2);
        app()->setLocale($this->lang);

        $this->breadcrum = $this->generateLinkProvince($province);
        $this->breadcrum .= $this->generateLinkLocation($province, $poblacion);
        $this->breadcrum .= "<li><a href='#'>" . ucwords($propiedad) . "</a></li>";

        $parts = explode('-', $propiedad);
        $n = sizeof($parts);
        $ref_code = $parts[$n - 2] . '-' . $parts[$n - 1];
        $propiedad = $this->getProperty($ref_code);
        if($propiedad != null) {
            $propiedad->init();
            $otros = $this->getOthers($propiedad->type);
            return view('property_info')
                ->with('propiedad', $propiedad)
                ->with('otros', $otros)
                ->with('controller', $this);
        }
        else{
            $ref_code = $parts[$n - 1];
            $propiedad = $this->getProperty($ref_code);
            if($propiedad != null) {
                $propiedad->init();
                $otros = $this->getOthers($propiedad->type);
                return view('property_info')
                    ->with('propiedad', $propiedad)
                    ->with('otros', $otros)
                    ->with('controller', $this);
            }
            return redirect('/error');
        }
    }
}
