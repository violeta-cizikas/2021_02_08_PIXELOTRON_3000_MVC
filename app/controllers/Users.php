<?php
// 13 _ sukuriama kontrolerio klase Users
class Users extends Controller
{
    // 21
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    // kuriamas register
    public function register()
    {

        // echo 'Register in progress';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sanitize Post Array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // create data 
            $data = [
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),

                'firstnameErr' => '',
                'lastnameErr' => '',
                'emailErr' => '',
                'passwordErr' => '',
                'confirmPasswordErr' => '',
            ];

            //////////////////////////////////////////////////////////
            // Validate firstname
            if (empty($data['firstname'])) {
                $data['firstnameErr'] = "Please enter Your Firstname";
            }

            //////////////////////////////////////////////////////////
            // Validate lastname 
            if (empty($data['lastname'])) {
                $data['lastnameErr'] = "Please enter Your Lastname";
            } else if (strlen($data['lastname']) > 50) {
                $data['lastnameErr'] = "Please enter less then 50 letters";
              // preg_match('/^[\p{L} ]+$/u' - tikrinimas ar sudaryta is viso pasaulio raidziu  
            } else if (!preg_match('/^[\p{L} ]+$/u', $data['lastname'])) {
                $data['lastnameErr'] = "Please only use letters";
            } 

            //////////////////////////////////////////////////////////
            // Validate email
            if (empty($data['email'])) {
                $data['emailErr'] = "Please enter Your Email";
              // filter_var($data['email'] - tikrinimas, kad email teisingo formato 
            } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailErr'] = "Please enter a valid Email";
              // jei DB egzistuoja su tokiu email - klaida (tokiu atveju - zinute 'email'as jau uzimtas')
            } else if ($this->userModel->findUserByEmail($data['email'])) {
                $data['emailErr'] = "Email already taken";
            }

            //////////////////////////////////////////////////////////
            // Validate passwords
            if (empty($data['password'])) {
                $data['passwordErr'] = "Please enter Your Password";
            } elseif (strlen($data['password']) < 4) {
                $data['passwordErr'] = "Please enter atleast 4 symbols";
            }

            if ($data['password'] != $data['confirmPassword']) {
                $data['confirmPasswordErr'] = "Passwords should match";
            }

            //////////////////////////////////////////////////////////
            // jei nėra klaidų
            if (empty($data['firstnameErr']) && empty($data['lastnameErr']) && empty($data['emailErr']) && empty($data['passwordErr']) && empty($data['confirmPasswordErr'])) {

                // hash password // saugus budas laikyti password'a / atrodys kaip unikalus simboliu kratinys
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    // success user added 
                    // set flash msg
                    flash('register_success', 'You have registered successfully');
                    // header("Location: " . URLROOT . "/users/login");
                    redirect('/users/login');
                } else {
                    die('Something went wrong in adding user to db');
                }

            } else {
                // set flash msg
                flash('register_fail', 'please check the form', 'alert alert-danger');
                // load view with errors 
                $this->view('pages/register', $data);
            }

        } else{
            // kuriamas $data, nes i view bus paduodami atvaizduojami duomenys
            $data = [];
            // view() uzkrauna html turini
            $this->view('pages/register', $data);
        }  
    }

    // kuriamas login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sanitize Post Array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // create data 
            // trim istrina spaces'us is stringo pradzios arba galo
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'emailErr' => '',
                'passwordErr' => '',
            ];
            // rezultatas irasomas i kintamaji
            $user = $this->userModel->findUserByEmail($data['email']);
            // patikrinimas ar user nerastas
            if ($user === false) {
                $data['emailErr'] = "User does not exist";
            } else {
                // ar sutampa paswordai, jei sutampa - php laikinai nukilinamas
                // password_verify - tikrina ar suhashintas paswordas db su tampa su ivestu psrwrd
                if (password_verify($data['password'], $user['password'])) {
                    // die('ok');
                    // isimenama, kad vartotojas yra prisijunges
                    $_SESSION['user'] = $user;
                    // nurodomas adresas kur nukreipiama
                    redirect('/pages/add_new_pixels');
                   // jei nesutampa - klaidos pranesimas
                } else {
                    $data['passwordErr'] = "Password incorrect";
                }
            }
        } else {
            // create some data to load into vie
            $data = [];
        }        
        // view() uzkrauna html turini
        $this->view('pages/login', $data);
    }

    // kuriamas logout
    public function logout()
    {
        $_SESSION['user'] = null;
        // sesijos istrynimas
        session_destroy();
        // nukreipimas
        redirect('/users/login');
    }
}