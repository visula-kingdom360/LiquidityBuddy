<?php 
    namespace App\Models\Hardcoded;

    use CodeIgniter\Model;

    class storedText extends Model
    {
        // function screenWiseDataList($screen, $lang = 'en')
        // {

        //     $blueprint = $this->db->table('screen');
        //     $query = $blueprint->where(['screen_code' => $screen]);
        //     $query = $blueprint->join('screen','screen.screen_code = '.$screen);
        //     $query = $blueprint->join('stored_text','stored_text.screen_code = screen.screen_code');
        //     $query = $blueprint->join('stored_text_lang_map','stored_text.stored_text = stored_text_lang_map.stored_text AND stored_text_lang_map.lang_code = '.$lang);
            
        //     $data = $query->get()->getResult();

        //     return $data;
        //     // if($screen == 'login')
        //     // {
        //     //     if($lang == 'en')
        //     //     {
        //     //         $data = [
        //     //             'LoginTitle' => 'Login Screen',
        //     //             'LoginHeader' => 'Login',
        //     //             'UsernameLabel' => 'Usernmae',
        //     //             'UsernamePlaceholder' => 'Enter your username or email here',
        //     //             'PasswordLabel' => 'Password',
        //     //             'PasswordPlaceholder' => 'Enter your password',
        //     //             'LoginButton' => 'Login',
        //     //             'RestButton' => 'Reset',
        //     //             'SignupPara' => 'If you are a new user please ',
        //     //             'SignupAnchor' => 'signup now',
        //     //             'SignupLink' => '',
        //     //         ];
                    
        //     //         return $data;
        //     //     }
        //     // }
        // }

    }
?>