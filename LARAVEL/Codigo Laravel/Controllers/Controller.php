<?php

/**
 * Controller Base
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



use Illuminate\Http\Request;

//use DB;
use View;

use Carbon\Carbon;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

use Spatie\Sitemap\Sitemap;

use Illuminate\Support\Facades\Route;

/**
 * Esta clase definen el Controlador base de la Aplicacion, contiene el comportamiento estandar que los demás
 * controladores pueden implementar, y metodos genericos que cualqueir vista puede usar. Acá se gestiona el
 * breadcrum del sitio; se trata las URLs especiales, aquellas que por su taxónomia se enmascaran con las URLs
 * de tipo /{province}, y que tienen que ser detectadas en runtime para su correcto procesamiento. Este
 * controlador tambien da soporte para gestionar los diferentes idiomas que pisos.click utiliza.
 * Class Controller
 * @author Ewwinlopezve@gmail.com e. López
 * @since V-1.0
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    const URL_TERMS = 1;
    const URL_HELP = 2;
    const URL_FOR_SALE = 3;
    const URL_TO_RENT = 4;
    const URL_SITEMAP = 5;
    const URL_CONTACT_US = 6;
    const URL_AGENTS = 7;
	const URL_COOKIES = 8;
    const URL_ADVERTISE = 9;

    const index_url = [
        self::URL_TERMS, 
        self::URL_HELP,
        self::URL_FOR_SALE,
        self::URL_TO_RENT,
        self::URL_SITEMAP,
        self::URL_CONTACT_US,
		self::URL_AGENTS,
        self::URL_ADVERTISE,
		self::URL_COOKIES];


    const url_special_en = [
        self::URL_TERMS => 'terms',
        self::URL_HELP => 'help',
        self::URL_FOR_SALE => 'for-sale',
        self::URL_TO_RENT => 'to-rent',
        self::URL_SITEMAP => 'sitemap',
        self::URL_ADVERTISE => 'advertise',
        self::URL_CONTACT_US => 'contact-us',
		self::URL_COOKIES => 'cookies',
        self::URL_AGENTS => 'agents'];

    const url_special_es = [
        self::URL_TERMS => 'terminos',
        self::URL_HELP => 'ayuda',
        self::URL_FOR_SALE => 'en-venta',
        self::URL_TO_RENT => 'para-rentar',
        self::URL_SITEMAP => 'mapa-de-sitio',
        self::URL_CONTACT_US => 'contactenos',
        self::URL_ADVERTISE => 'anunciate',
		self::URL_AGENTS => 'agentes',
		self::URL_COOKIES => 'cookies'];

    /**
     * Almacena el idioma actual de la página, por defecto es ingles 'en'
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @property string
     */
    protected $lang = 'en';

    /**
     * Alamacena el breadcrum actual, su contenido varia en función de donde se encuentra navegando el usuario
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @property string
     */
    protected $breadcrum;

    /**
     * autogenerado
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Retorna el idioma actual del sitio que el usuario ha establecido. El idioma por defecto es en (Ingles)
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return string Retorna el idioma actual del sitio que el usuario ha establecido. El idioma por defecto es en (Ingles)
     */
    public function getLang(){
        return $this->lang;
    }

    /**
     * Determina si se trata de una url especial. Estas estan definidas en url_special_en y url_special_es y se
     * deducen en función del idioma actual que el usuario esta usando
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param $route string URI a testear
     * @param $compare string[] Casos a analizar
     * @return int Devuelve el indice del URL especial, si esta existe
     */
    protected function isUrlSpecial($route, $compare){
        foreach (self::index_url as $key)
            if(isset($compare[$key]) && $route === $compare[$key])
                return $key;
        return -1;
    }

    /**
     * retorna la URL especial ubicada en la posicion $key del arreglo de urls especiales
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param int $key
     * @return string
     */
	 
	 public function test(){
          
         
        // $input=$i->all();
		
		
		$path= base_path()."/sitemap.xml";

		$routeList = Route::getRoutes();
		
		$sitemap=Sitemap::create('https://pisos.click/me');
		
		$arr=array();
		$i=0;
foreach ($routeList as $value)
{
   	
	$sitemap ->add(Url::create('https://pisos.click/'.$value->uri));
   }

 
 $sitemap->writeToFile($path);		

	
	}
	 
	 
    public function getSpecialURL($key){
        if($this->lang === 'en'){
            return self::url_special_en[$key];
        } else{
            return self::url_special_es[$key];
        }
    }

    /**
     * Devuelve el breadcrum donde esta ubicado el usuario
     * @author Ewwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return string Retorna el breadcrum, este método es invocado en el template
     * /resources/views/partials/search/result.blade.php
     */
    public function getBreadcrum(){
        return $this->breadcrum;
    }



    public function getProvinceLabel($province){
        if($this->lang == 'en')
            return "$province province";
        return "Provincia de $province";
    }
}
