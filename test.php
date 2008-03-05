Hello, this is <?=$this->name;?> <br/>
And your name is <?=$this->customer_name;?><br/>

<br/>
<?foreach($this->rows as $key):?>
Mein Name ist <?=$key?><br/>
<?endforeach;?>