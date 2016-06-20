<?php


class HomeController extends Controller
{
    public function indexAction()
    {
        echo 'index çalıştı<br>';
        $validation = Validation::make(Request::post(), array(
            'name' => array(
                'required' => 'Lütfen adınızı ve soyadınızı yazın.',
                'minLength' => array(
                    'value' => 3,
                    'message' => 'Ad Soyad alanına çok kısa bir deger girdiniz.'
                )
            ),
            'mail' => array(
                'required' => 'Lütfen e-posta adresinizi yazın.',
                'email' => 'Lütfen geçerli bir e-posta adresinizi yazın.'
            ),
            'comment' => array(
                'minLength' => array(
                    'value' => 3,
                    'message' => 'Yorumunuz çok kısa.'
                )
            ))
        );

        if ($validation->valid()) {
            echo 'oldu';
        } else {
            echo 'olmadı';
        }


        var_dump(Config::get());
    }

}