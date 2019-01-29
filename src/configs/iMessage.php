<?php

interface iMessage {
  public function sendMessage($receiver);
  public function getMessages($id);
}
