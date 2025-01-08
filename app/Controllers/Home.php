<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function myProfile(): string
    {
        $data['title'] = 'My Profile';
        return view('/my_profile', $data);
    }
    public function contact(): string
    {
        $data['title'] = 'My Contact';
        return view('user/contact', $data);
    }
    public function help(): string
    {
        $data['title'] = 'Eco Market sellau memberikan bantuan!';
        return view('user/about', $data);
    }
    public function about(): string
    {
        $data['title'] = 'About';
        return view('user/help', $data);
    }
    public function offline(): string
    {
        return view('/offline.html');
    }
}
