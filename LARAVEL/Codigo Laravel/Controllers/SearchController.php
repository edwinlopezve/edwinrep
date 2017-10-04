<?php
/**
 * Controlador general para busquedas
 */

namespace App\Http\Controllers;

use App\Models\Poblacion;
use App\Models\Propiedad;
use App\Models\Provincia;
use App\Models\Usuario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/**
 *
 * Controlador para gestionar la busqueda de propiedades por poblaciones, ciudades; asi como gestionar casos especiales
 * de URLs que son enmascaradas por la URL de formato /{province}. Este controlador gestiona los listados de propiedades
 * en función a los parametros de busqueda definidos por el usuario, asi como enrutar a otras páginas como lo son:
 * /terms, /help, /sitemap y otras de caracter general
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * Contiene el request (Solicitud del usuario $_REQUEST)
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var Request Almacena el request actual del usuario
     */
    protected $request;

    /**
     * Contiene el paginador actual, este es construido directamente por el ORM Eloquent
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var LengthAwarePaginator Contiene el paginador actual
     */
    protected $links;

    /**
     * Almacena el modo de ordenamiento
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var int Almacena el modo de ordenamiento
     */
    protected $orderby = "";

    /**
     * Si se ha definido un ambito, [Renta ó Venta] para las propiedades se almacena en $mode
     * Almacena el modo de ordenamiento
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var string Si se ha definido un ambito, [Renta ó Venta] para las propiedades se almacena en $mode
     */
    protected $mode = "";

    /**
     * Almacena el punto de navegación actual que  tiene página en funcion de las provicias, poblaciones o
     * propiedades
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var
     */
    protected $functionality;

    /**
     * Almacena el valor actual que muestra el input en el formulario de busqueda
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @var
     */
    protected $labelSearch;
    const ORDER_RECOMMENDED = 1;
    const ORDER_LOWER_PRICE = 2;
    const ORDER_HIGHEST_PRICE = 3;
    const ORDER_MOST_RECENT = 4;

    /**
     * Permite fijar un query en modo rent o sales si el usuario asi lo
     * especifica en su request; para ello se fija la comparación debida contra la columna leasehold
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param $q \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder Permite fijar un query en modo rent o sales si el usuario asi lo
     * especifica en su request
     */
    private function getSalesOrRent($q)
    {
        if (isset($_GET['type'])) {
            if (strtolower($_GET['type']) === 'rent')
                $q->where('leasehold', '=', 1);
            if (strtolower($_GET['type']) === 'sales')
                $q->where('leasehold', '=', 0);
        }
        return $q;
    }

    /**
     * Permite descartar publicaciones que no tiene definido una provicia o un town.
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param $q \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder Permite descartar publicaciones que no tiene definido una
     * provicia o un town.
     */
    private function setAllLocation($q)
    {
        $q->where('province', '!=', null);
        $q->where('town', '!=', null);
        return $q;
    }

    /**
     * Retorna los parametros de paginación establecidos por el usuario, page and offset, sino son proporcionado se
     * envian los valores por defecto page=1 y size=10
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param $parameters
     * @return array Retorna los parametros de paginación establecidos por el usuario, page and offset
     */
    private function getPageAndSize($parameters)
    {
        $position = [];
        $position['page'] = isset($parameters['page']) ? intval($parameters['page']) : 1;
        $position['size'] = isset($parameters['size']) ? intval($parameters['size']) : 10;
        return $position;
    }

    /**
     * Retorna el modo de ordenamiento especificado por el usuario; los posibles valores son :
     * [SearchController::ORDER_RECOMMENDED, SearchController::ORDER_LOWER_PRICE, SearchController::ORDER_HIGHEST_PRICE,
     * SearchController::ORDER_MOST_RECENT]; si el usuario omite este parametro en el request se retorna el valor por
     * defecto SearchController::ORDER_RECOMMENDED
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return int Retorna el modo de ordenamiento especificado por el usuario
     */
    private function getOrderMode()
    {
        return isset($_GET['order']) ? intval($_GET['order']) : self::ORDER_RECOMMENDED;
    }


    /**
     * Configura y retorna el objeto query con todas las posibles especificaciones
     * que el usuario puede definir en la barra de busquedas detallas; Los parametros baths, beds y pool
     * se estan comparando como tipo string
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param $q \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder Configura y retorna el objeto query con todas las posibles especificaciones
     * que el usuario puede definir en la barra de busquedas detallas
     */
    private function searchProperties($q)
    {
        $parameters = $this->request->all();

        if (isset($parameters['min-price']) && isset($parameters['max-price']) &&
            intval($parameters['min-price']) > 0 && intval($parameters['max-price']) > 0
        ) {
            $q->whereBetween('price', [$parameters['min-price'], $parameters['max-price']]);
        } else {
            if (isset($parameters['min-price']) && intval($parameters['min-price']) > 0)
                $q->where('price', '>=', $parameters['min-price']);

            if (isset($parameters['max-price']) && intval($parameters['max-price']) > 0)
                $q->where('price', '<=', $parameters['max-price']);
        }
        if (isset($parameters['property-type']) && !empty($parameters['property-type']))
            $q->where('type', 'like', $parameters['property-type']);
        if (isset($parameters['bedrooms'])) {
            $val = intval($parameters['bedrooms']);
            if ($val == 100)
                $q->where('beds', '>', 4);
            else if ($val > 0) {
                $q->where('beds', '=', $val);
            }
        }
        if (isset($parameters['bathrooms'])) {
            $val = intval($parameters['bathrooms']);
            if ($val == 100)
                $q->where('baths', '>', 4);
            else if ($val > 0) {
                $q->where('baths', '=', $val);
            }
        }
        if (isset($parameters['pool']) && $parameters['pool'] === 'on') {
            $q->where('pool', '=', '1');
        }
        if (isset($parameters['new_build']) && $parameters['new_build'] === 'on') {
            $q->where('new_build', '=', '1');
        }
        return $q;
    }

    /**
     * Retorna los resultados de la busqueda especificada por el usuario, esta busqueda puede ser implicita, accesando
     * la URL de alguna poblacion, provincia o las especiales /to-rent o /for-sale; pero tambien puede ser explicita
     * fijando los valores en la barra de busqueda para precios y otros atributos que se pueden definir
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param $busqueda \Illuminate\Database\Eloquent\Builder
     * @return Propiedad[] Retorna los resultados de la busqueda especificada por el usuario
     */
    private function getResults($busqueda)
    {
        $parameters = $this->request != null ? $this->request->all() : [];
        $position = $this->getPageAndSize($parameters);
        $this->links = $busqueda->paginate($position['size']);

        switch ($this->getOrderMode()) {
            case self::ORDER_RECOMMENDED:
                $busqueda = $busqueda->orderBy('featured', 'desc');
                break;
            case self::ORDER_LOWER_PRICE;
                $busqueda = $busqueda->orderBy('price', 'asc');
                break;
            case self::ORDER_HIGHEST_PRICE;
                $busqueda = $busqueda->orderBy('price', 'desc');
                break;
            case self::ORDER_MOST_RECENT;
                $busqueda = $busqueda->orderBy('date_prop', 'desc');
                break;
        }
        return $busqueda->offset(($position['page'] - 1) * $position['size'])->take($position['size'])->get();
    }

    /**
     * Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en el AGENTE y el controlador actual, este método es invocado
     * para la URL de tipo /to-rent
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten para la renta y el controlador actual
     */
    public function actionAgent($agent)
    {
        //Here get properties for agent
            //get Id of agent
        	$agents = DB::table('usuarios_detalles')->where('empresa', '=', $agent)->get(); 
            $this->agent_id = $agents[0]->usuario_id;
            $this->agent_name = $agents[0]->empresa;
            
                if ($this->agent_id == null)
                    return redirect('error');
        
        $query = Propiedad::where('usuario_id', '=', $this->agent_id);
        $query = $this->setAllLocation($query);
        $propiedades = $this->getResults($query);
        
        return view('agents')->with('propiedades', $propiedades)->with('controller', $this);
    }
    
    /**
     * Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten para la renta y el controlador actual, este método es invocado
     * para la URL de tipo /to-rent
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten para la renta y el controlador actual
     */
    public function actionToRent()
    {
        $query = Propiedad::where('leasehold', '=', 1);
        $query = $this->setAllLocation($query);
        $propiedades = $this->getResults($query);
        return view('search')->with('propiedades', $propiedades)
            ->with('controller', $this);
    }

    /**
     * Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en venta y el controlador actual, este método es invocado
     * para la URL de tipo /for-sale
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en venta y el controlador actual
     */
    public function actionForSale()
    {
        $query = Propiedad::where('leasehold', '=', 0);
		
		$query;
		
        $query = $this->setAllLocation($query);
        $propiedades = $this->getResults($query);
        return view('search')->with('propiedades', $propiedades)
            ->with('controller', $this);
    }

    /**
     * View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en la provicia definida por {$province} y el controlador actual; este método es invocado
     * para la URL de tipo /{province}
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param string $province Provincia especificada por el usuario en el campo de busqueda o por medio de una URL
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en la provicia definida por {$province} y el controlador actual
     */
    public function getProvince($province)
    {
        $province = str_replace('-', ' ', $province);

        $this->breadcrum = "<li><a href='#'>" . ucwords($province) . "</a></li>";

        $provincia = Provincia::where('nom_prov', 'like', "$province%")->first();
        if ($provincia == null)
            return redirect('error');

        $this->provinceid = $provincia->cod_prov;
        
        $busqueda = Propiedad::where('province', $provincia->cod_prov)
            ->where('status', 1);
        $busqueda = $this->searchProperties($busqueda);
        $busqueda = $this->getSalesOrRent($busqueda);
        $busqueda = $this->setAllLocation($busqueda);
		
		
		
        return view('search')->with('propiedades', $this->getResults($busqueda))
            ->with('controller', $this);
    }


    /**
     * Este metodo podria resolver busquedas implicitas o explicitas por parte del usuario en cuanto a propiedades, pero
     * tambien tiene la capacidad de resolver otros páginas que dados los requemientos del SEO se ven enmcascaradas por
     * las URLs de tipo /{provinces}, estas son: /terms, /sitemap, /agents, /help, /contact, for-sale y /to-rent, o sus equivalentes en español. En
     * caso de tratarse de una busqueda existe la posibilidad de que esta halla sido accesada por medio de las URL /for-sale
     * ó /to-rent, las cuales son tratadas como un caso especial de busqueda en las que no se discrimina por provincias,
     * para el resto de busquedas se determina si el usuario definio o no parametros especificos. El resultado final
     * de una busqueda siempre retorna el template /resources/views/search.blade.php, con el listado de propiedades
     * y el controlador actual como gestor de idiomas y breadcrum. Este metodo es invocado desde el gestor de enrutamiento
     * que esta ubicado en /routes/web.php
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param $request Request Objeto global que contiene los requerimientos de usuario, variables de sesión, archivos
     * y demás estructuras que PHP gestiona para que el desarrollador pueda interpretar y controlar toda lo necesario
     * @param $province Provincia Podría tratarse de una provincia especificada por el usuario en el campo de busqueda
     * o por medio de una URL; pero tambien podría tratarse de los siguientes valores: help, sitemap, agents, contact, terms
     * o sus equivalentes en español
     * @return View  Podría ser la vista que se esta ubicada en /resources/views/search.blade.php; u otras vistas
     * dependiendo de si el parametro $province no las esta enmascarando; las otras vistas que podria retornar son:
     * 1.- /resources/views/terms.blade.php, 2.- /resources/views/sitemap.blade.php, 3.- /resources/views/agents.blade.php,
     * 4.- /resources/views/help.blade.php, 5.- /resources/views/contact.blade.php
     */
    public function actionProvince(Request $request, $province)
    {
        $this->request = $request;
        $this->lang = strtolower(substr($request->route()->uri, 0, 2));
        app()->setLocale($this->lang);
        $this->functionality = $province;
        $this->provincedisplay = $province;
        $this->provinceid = "";
        $this->poblaciondisplay = "";
        $this->poblacionid = "";
        $array_especial = $this->lang === 'es' ? self::url_special_es : self::url_special_en;
		array_push($array_especial,"cookies");
        $special_key = $this->isUrlSpecial($province, $array_especial);

        if ($special_key != -1) {
			
			
            switch ($special_key) {
                case self::URL_TERMS:
                    return view('terms')->with('controller', $this);
                    break;
                case self::URL_HELP:
                    return view('help')->with('controller', $this);
                    break;
                case self::URL_FOR_SALE:
                    return $this->actionForSale();
                    break;
                case self::URL_TO_RENT:
                    return $this->actionToRent();
                    break;
                case self::URL_SITEMAP:
                    return view('sitemap')->with('controller', $this);
                    break;
                case self::URL_CONTACT_US:
                    return view('contact')->with('controller', $this);
                    break;
                case self::URL_AGENTS:
                    return view('listagents')->with('controller', $this);
                    break;
                case self::URL_ADVERTISE:
                    return view('advertise')->with('controller', $this);
                    break;
				case self::URL_COOKIES:
                    return view('cookies')->with('controller', $this);
                    break;
            }
        }

        $this->setMode();
        return $this->getProvince($province);
    }

    /**
     * Retorna la vista que se esta ubicada en /resources/views/search.blade.php, las propiedades son filtradas en
     * funcion de la provicia y poblacion que de forma implicita o explicita define el usuario, bien sea por medio
     * de una busqueda o una URL; a la vista se le añade el controlador actual para gestionar la traduccion de los items
     * y el breadcrum. Este metodo es invocado desde el gestor de enrutamiento que esta ubicado en /routes/web.php
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param string $province Provincia especificada por el usuario en el campo de busqueda o por medio de una URL
     * @param string $poblacion Población especificada por el usuario en el campo de busqueda o por medio de una URL
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en la provicia definida por {$province} y {$población}. El controlador actual tambien
     * es enviado como parametro
     *
     */
    public function getLocation($province, $poblacion)
    {
        $province = str_replace('-', ' ', $province);
        $poblacion = str_replace('-', ' ', $poblacion);

        $this->labelSearch = ucwords($province) . " " . ucwords($poblacion);

        $this->breadcrum = "<li><a href='" . url('/' . $this->lang . '/' . $province) . "'>" . ucwords($province) . "</a>></li>";
        $this->breadcrum .= "<li><a href='#'>" . ucwords($poblacion) . "</a></li>";

        $provincia = Provincia::where('nom_prov', 'like', "$province%")->first();
        if ($provincia == null)
            return redirect('error');

        $poblacion = Poblacion::where('nom_pob', 'like', "$poblacion%")->where('cod_prov', $provincia->cod_prov)->first();
        if ($poblacion == null)
            return redirect('error');
        
        $this->poblacionid = $poblacion->cod_pob;
        $this->provinceid = $provincia->cod_prov;

        $busqueda = Propiedad::where('location_id', $poblacion->cod_pob)
            ->where('province', $provincia->cod_prov)
            ->where('status', 1);
        $busqueda = $this->searchProperties($busqueda);
        $busqueda = $this->getSalesOrRent($busqueda);
        $busqueda = $this->setAllLocation($busqueda);
        return view('search')->with('propiedades', $this->getResults($busqueda))
            ->with('controller', $this);
    }

    /**
     * Retorna la vista que se esta ubicada en /resources/views/search.blade.php, las propiedades son filtradas en
     * funcion de la provicia y poblacion que de forma implicita o explicita define el usuario, bien sea por medio
     * de una busqueda o una URL; a la vista se le añade el controlador actual para gestionar la traduccion de los items
     * y el breadcrum. Este método podria no existir, pero se creo por si mas adelante las provincia pudieran tener
     * otro tipos de paginas de proposito genera que pudieran ser enmascaradas por las URLs de tipo /{province}/{poblacion}
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see Propiedad Propiedad
     * @param Request $request Request Objeto global que contiene los requerimientos de usuario, variables de sesión, archivos
     * y demás estructuras que PHP gestiona para que el desarrollador pueda interpretar y controlar toda lo necesario
     * @param string $province Provincia especificada por el usuario en el campo de busqueda o por medio de una URL
     * @param string $poblacion Población especificada por el usuario en el campo de busqueda o por medio de una URL
     * @return View Retorna la vista que se esta ubicada en /resources/views/search.blade.php, pasandole como parametro
     * las propiedades que esten en la provicia definida por {$province} y {$poblacion}. El controlador actual tambien
     * se pasa como parametro, para la gestión del idioma y el breadcrum
     */
    public function actionLocation(Request $request, $province, $poblacion)
    {
        $this->request = $request;
        $this->lang = strtolower(substr($request->route()->uri, 0, 2));
        $this->functionality = $province . '/' . $poblacion;
        $this->provincedisplay = $province;
        $this->provinceid = "";
        $this->poblaciondisplay = $poblacion;
        $this->poblacionid = "";
        app()->setLocale($this->lang);
        $this->setMode();
        
        if($province == "agents") { //is agents search
            return $this->actionAgent($poblacion);
        }else {
            return $this->getLocation($province, $poblacion);
        }
    }

    /**
     * Fija a nivel interno el modo de busquedas, para rentar o para vender; si el usuario no define algun modo, se
     * omite este parametro en las busquedas
     * @see SearchController::$mode Modo de busqueda
     * @see SearchController::getSalesOrRent() Rentar o Vender
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     */
    private function setMode()
    {
        $this->mode = (isset($_GET['type']) && (strtolower($_GET['type']) === 'sales' || strtolower($_GET['type']) === 'rent')) ? $_GET['type'] : "";
    }

    /**
     * Retorna el modo de busqueda ("vender" ó "rentas" ó null)
     * @see SearchController::$mode Modo de busqueda
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @see SearchController::$mode Modo de busqueda
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Obtiene el texto que se puede observar sobre los resultados de una busqueda, soporta la internacionalización.
     * Este método es invocado desde el template /resources/views/partials/search/result.blade.php
     * @link  https://laravel.com/docs/5.4/localization Documentación oficial de Laravel
     * @return string
     */
    public function getResumenSearch()
    {
        $controllerName = Route::current()->getName();
        $parameters = $this->request != null ? $this->request->all() : [];
        if ($controllerName === 'forSale' || $this->mode === 'sales') {
            $patron = trans('search.properties_for_sale');
            $str = sprintf($patron, $this->links->total());
        } else if ($controllerName === 'toRent' || $this->mode === 'rent') {
            $patron = trans('search.properties_to_rent');
            $str = sprintf($patron, $this->links->total());
        } else if ($controllerName === 'agents') {
            $patron = trans('search.properties_to_rent');
            $str = "";
        } else {
            $patron = trans('search.properties_results');
            $str = sprintf($patron, $this->links->total());
        }
        return $str;
    }

    /**
     * Retorna el querystring para construir el mecanismo de paginación o de ordenamiento
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param bool $withoutPage Si es true el parametro indica que se contruya URLs de paginacion, sino, se esta
     * indicando que la url a construir sera de ordenamiento
     * @return string Retorna el querystring para construir el mecanismo de paginación o de ordenamiento
     */
    private function getQueryString($withoutPage = false)
    {
        $parameters = $this->request != null ? $this->request->all() : [];
        if ($withoutPage && isset($parameters['page']))
            unset($parameters['page']);
        else if ($withoutPage == false && isset($parameters['order']))
            unset($parameters['order']);
        $string_query = "";
        $first = true;
        foreach (array_keys($parameters) as $key) {
            if (!$first)
                $string_query .= "&";
            $string_query .= $key . "=" . $parameters[$key];
            $first = false;
        }
        return $string_query;
    }

    /**
     * Inicializa una URL de ordamiento en funcion de del valor de $val
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param $val int Puede ser alguno de estos valores : (SearchController::ORDER_RECOMMENDED,
     * SearchController::ORDER_LOWER_PRICE, SearchController::ORDER_HIGHEST_PRICE, SearchController::ORDER_MOST_RECENT)
     * @return string Inicializa una URL de ordamiento en funcion de del valor de $val
     */
    public function getOrderUrl($val)
    {
        $string_query = $this->getQueryString();
        switch ($val) {
            case self::ORDER_RECOMMENDED:
                $string_query .= "&order=" . self::ORDER_RECOMMENDED;
                break;
            case self::ORDER_LOWER_PRICE:
                $string_query .= "&order=" . self::ORDER_LOWER_PRICE;
                break;
            case self::ORDER_HIGHEST_PRICE:
                $string_query .= "&order=" . self::ORDER_HIGHEST_PRICE;
                break;
            case self::ORDER_MOST_RECENT:
                $string_query .= "&order=" . self::ORDER_MOST_RECENT;
                break;
        }
        return url('/' . $this->lang . '/' . $this->functionality) . "?$string_query";
    }

    /**
     * Imprime la pagina en la página de resultados, es invocado en el layout /resources/views/partials/search/result.blade.php
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     */
    public function getPagination()
    {
        $string_query = $this->getQueryString(true);
        $this->links->setPath(url('/' . $this->lang . '/' . $this->functionality) . "?$string_query");
        echo $this->links->links();
    }

    /**
     * Retorna la class CSS para destacar el en control de ordenamiento el metodo que se esta usando
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @param $val
     * @return string retorna la class CSS para destacar el en control de ordenamiento el metodo que se esta usando
     */
    public function getClassForEnableMode($val)
    {
        return $val == $this->getOrderMode() ? 'class="active" selected' : "";
    }

    /**
     * Configura la etiqueta en el control de ordenamiento
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return string Configura la etiqueta en el control de ordenamiento
     */
    public function getLabelForEnableMode()
    {
        $str = "";
        switch ($this->getOrderMode()) {
            case self::ORDER_RECOMMENDED:
                $str = trans('search.order.recommended');
                break;
            case self::ORDER_LOWER_PRICE:
                $str = trans('search.order.lowest_price');
                break;
            case self::ORDER_HIGHEST_PRICE:
                $str = trans('search.order.highest_price');
                break;
            case self::ORDER_MOST_RECENT:
                $str = trans('search.order.most_recent');;
                break;
        }
        return $str;
    }

    /**
     * Retorna un valor en el formato "" ó {province} ó {province}/{poblacion}
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return string Retorna un valor en el formato "" ó {province} ó {province}/{poblacion}
     */
    public function getFuncionality()
    {
        return $this->functionality;
    }

    /**
     * Retorna los usuarios que tiene una imagen asignada
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return Usuario Retorna los usuarios que tiene una imagen asignada
     */
    public function getAgents()
    {
        return Usuario::where('imagen', '<>', null)->get();
    }

    /**
     * Retorna el valor del campo search en los formularios de busqueda
     * @author Edwinlopezve@gmail.com e. López
     * @since V-1.0
     * @return string Retorna el valor del campo search en los formularios de busqueda
     */
    public function getLabelSearch()
    {
        return $this->labelSearch;
    }
	
	public function rute()
	{
		app()->setLocale('en');
        
		return view('cookies')->with('controller', $this);
	}
}
