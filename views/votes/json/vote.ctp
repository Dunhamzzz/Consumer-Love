<?php
if(isset($error)) {
	echo $this->Js->object(array('e' => $error));
} else {
	echo $this->Js->object($result);
}