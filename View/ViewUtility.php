<?php

function safeEcho($x) : void {
  echo htmlspecialchars($x, ENT_IGNORE);
}
