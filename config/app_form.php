<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
  'inputContainer' => '<div class="form-group">{{content}}</div>',  
  'input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}/>',
  'textarea' => '<textarea class="form-control" row="3" name="{{name}}"{{attrs}}>{{value}}</textarea>',
  'select' => '<select class="form-control" name="{{name}}"{{attrs}}>{{content}}</select>',
  'radio' => '<input class="form-control" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
  'button' => '<button class="btn btn-primary"{{attrs}}>{{text}}</button>',
  'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}',
];