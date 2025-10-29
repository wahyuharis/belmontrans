<?php

class Template
{

    private $title_page = "Page Title";
    private $content = "";

    function set_title($title)
    {
        $this->title_page = $title;
        return $this;
    }

    function set_content($content = '', $data = [])
    {
        $ci = &get_instance();

        $this->content = $ci->load->view($content, $data, true);
        return $this;
    }

    function set_html($html = '')
    {
        $ci = &get_instance();

        $this->content = $html;
        return $this;
    }

    function render()
    {
        $ci = &get_instance();

        $template_data['content'] = $this->content;
        $template_data['title_page'] = $this->title_page;


        $ci->load->view('template', $template_data);
    }
}
