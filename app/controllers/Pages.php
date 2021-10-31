<?php  
// sukuriama kontrolerio klase, nes naudojamas MVC
// extends - paveldimumas(praplecia)
class Pages extends Controller
{
    // perkeliama is 21 zingsnio, kad aktyvuotusi userModel
    // deklaravimas, kad klase turi property
    private $userModel;
    // deklaruojama, kad klase turi toki property
    private $pixelModel;
    // construct - ypatingas metodas vadinamas kontruktoriumi, nes, kai klase kuriama su raktazpdziu new - iskvieciamas konstruktorius
    // konstruktorius naudojamas nustatyti pradiniams klases property reiksmems
    public function __construct()
    {   
        // naudojamas metodas $this->model, kuris paveldetas is tevines klases Controller
        // ir sis metodas grazina Model, ir tuomet tas Model irasomas i sios klases property $this->userModel
        $this->userModel = $this->model('User');
        // $pixelModel nustatymas ir gavimas bei irasymas sios klases property
        $this->pixelModel = $this->model('Pixel');
    }

    ///////////////////////////////////////////////
    // kontrolerio metodas add_new_pixels atsakingas uz pikseliu pridejimo atvaizdavima
    public function add_new_pixels() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sanitize Post Array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // create data 
            // trim istrina spaces'us is stringo pradzios arba galo (kai is formos ateina)
            // asociatyvus masyvas
            $data = [
                'user_id' => $_SESSION['user']['user_id'],
                'coordinate_x' => trim($_POST['coordinate_x']),
                'coordinate_y' => trim($_POST['coordinate_y']),
                'color' => trim($_POST['color']),
                'size' => trim($_POST['size']),
                'coordinate_xErr' => '',
                'coordinate_yErr' => '',
                'title' => 'Create Pixel',
            ];

            //////////////////////////////////////////////////////////
            // Validate x_coordinate
            if (empty($data['coordinate_x'])) {
                $data['coordinate_xErr'] = "Please enter X coordinate";
            }

            //////////////////////////////////////////////////////////
            // Validate y_coordinate
            if (empty($data['coordinate_y'])) {
                $data['coordinate_yErr'] = "Please enter Y coordinate";
            }
            
            //////////////////////////////////////////////////////////
            // jei nėra klaidų
            if (empty($data['coordinate_xErr']) && empty($data['coordinate_yErr'])) {

                if ($this->pixelModel->create($data)) {
                    // success user added 
                    // set flash msg
                    flash('register_success', 'You have created pixel successfully');
                    // header("Location: " . URLROOT . "/users/login");
                    redirect('/pages/my_pixels');
                } else {
                    die('System error: fail to create pixel');
                }

            } else {
                // set flash msg
                flash('register_fail', 'please check the form', 'alert alert-danger');
                // load view with errors 
                $this->view('pages/register', $data);
            }
        } else {
            // sukuriami duomenys, kad juos paduoti views
            $data = ['title' => 'Create Pixel'];

        }
        // uzkraunamas views
        $this->view('pages/add_new_pixels', $data);

    }

    ///////////////////////////////////////////////
    // kontrolerio metodas my_pixels atsakingas uz pikseliu atvaizdavima plokstumoje
    public function my_pixels()
    {
        // sukuriami duomenys, kad juos paduoti i metoda get_user_pixels, kad grazintu pikselius pgl 'user_id'
        $data = [
            'pixels' => $this->pixelModel->get_user_pixels($_SESSION['user']['user_id']),
            // masyvo property nurodantis rodyti pikseliu lentele (flag'as)
            'showTable' => true,
        ];
        // uzkraunamas views
        $this->view('pages/my_pixels', $data);
    }

    ///////////////////////////////////////////////
    // kontrolerio metodas index atsakingas uz visu vartotoju pikseliu atvaizdavima plokstumoje
    public function index()
    {
        // sukuriami duomenys, kad juos paduoti i metoda get_all_pixels, kad grazintu visu vartotoju pikselius
        $data = [
            'pixels' => $this->pixelModel->get_all_pixels(),
            // masyvo property nurodantis nerodyti pikseliu lenteles (flag'as)
            'showTable' => false,
        ];
        // uzkraunamas views
        $this->view('pages/my_pixels', $data);
    }

    ///////////////////////////////////////////////
    // kontrolerio metodas pixel_delete atsakingas uz pikseliu istrynima
    public function pixel_delete() {
        // kvieciamas metodas delete_pixel ir istrinamas pikselis pgl pixel_id
        $this->pixelModel->delete_pixel($_POST['pixel_id']);
        redirect('/pages/my_pixels');
    }

    ///////////////////////////////////////////////
    // kontrolerio metodas pixel_edit atsakingas uz pikseliu edit'inima
    public function pixel_edit() {
        // pikselio istraukimas is DB pgl id
        $pixel = $this->pixelModel->get_pixel($_GET['pixel_id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sanitize Post Array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // create data 
            // trim istrina spaces'us is stringo pradzios arba galo (kai is formos ateina)
            // asociatyvus masyvas
            $data = [
                'user_id' => $_SESSION['user']['user_id'],
                'coordinate_x' => trim($_POST['coordinate_x']),
                'coordinate_y' => trim($_POST['coordinate_y']),
                'color' => trim($_POST['color']),
                'size' => trim($_POST['size']),
                'coordinate_xErr' => '',
                'coordinate_yErr' => '',
                'title' => 'Edit Pixel',
                'pixel_id' => $_GET['pixel_id'],
            ];

            //////////////////////////////////////////////////////////
            // Validate x_coordinate
            if (empty($data['coordinate_x'])) {
                $data['coordinate_xErr'] = "Please enter X coordinate";
            }

            //////////////////////////////////////////////////////////
            // Validate y_coordinate
            if (empty($data['coordinate_y'])) {
                $data['coordinate_yErr'] = "Please enter Y coordinate";
            }
            
            //////////////////////////////////////////////////////////
            // jei nėra klaidų
            if (empty($data['coordinate_xErr']) && empty($data['coordinate_yErr'])) {
                // redagavimui naudojamas update metodas
                if ($this->pixelModel->update($data)) {
                    // success user added 
                    // set flash msg
                    flash('register_success', 'You have created pixel successfully');
                    // header("Location: " . URLROOT . "/users/login");
                    redirect('/pages/my_pixels');
                } else {
                    die('System error: fail to create pixel');
                }

            } else {
                // set flash msg
                flash('register_fail', 'please check the form', 'alert alert-danger');
                // load view with errors 
                $this->view('pages/register', $data);
            }
        } else {
            // sukuriami duomenys, kad juos paduoti views
            $data = ['title' => 'Edit Pixel'];
        }
        // uzkraunamas views
        $this->view('pages/add_new_pixels', $data);
    }
}

