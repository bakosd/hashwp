<?php

class Modal
{
    protected $name;
    protected $header;
    protected $buttons;
    protected $content;
    protected $result;

    /**
     * @param $name
     * @param $header
     * @param $content
     * @param $buttons
     * name=>Actual name attribute || type - button=>Close || submit=>Submit || icon=> fa-icon || text=>The text inside button || form=>parent form's id
     * @param $result
     */
    public function __construct($name, $header, $content, $buttons, $result = null)
    {
        $this->name = $name;
        $this->header = $header;
        $this->content = $content;
        $this->buttons = $buttons;
        $this->result = $result;
    }

    public function getModal():string{
        $returnVal = "<div class='modal fade' id='$this->name-modal' tabindex='-1' aria-labelledby='$this->name' aria-hidden='true'><div class='modal-dialog'>
        <div id='$this->name-modal-content' class='modal-content'><div class='modal-header'>
                <h5 class='modal-title fw-2' id='register'>$this->header</h5>
                <button type='button' class='button d-flex justify-content-center align-items-center' data-bs-dismiss='modal' aria-label='Close'><i class='fa-solid fa-xmark'></i></button>
            </div>
            <div id='result'></div>
            $this->content
            <div class='modal-footer d-flex gap-2'>";
            foreach ($this->buttons as $button){
                $name = $button['name'];
                $type = $button['type'];
                $icon = $button['icon'];
                $text = $button['text'];
                $class_list = "px-2 d-flex justify-content-center align-items-center gap-2";
                $returnVal .= "<button name='$name' type='$type' ";
                if($button['type'] == "button") {
                    $class_list .= " button-2";
                    $returnVal .= " data-bs-dismiss='modal' ";
                }
                else{
                    $class_list .= " button";
                }
                if($button['type'] == "submit" && isset($button['form'])){
                    $form = $button['form'];
                    $returnVal .= " form= '$form' ";
                }
                $returnVal .= "class='$class_list'><i class='fa-solid $icon'></i>$text</button>";
            }
        $returnVal .= "</div></div></div></div>";
        return $returnVal;
    }

    public function showModal():void{
        echo $this->getModal()."\n<script> $(document).ready(function () { $('#".$this->name."-modal').modal('show'); }); </script>";
    }
}
?>
