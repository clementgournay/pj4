<?php


function get_fullbody_looks($clothes) {

	$looks = [];

	if (isset($clothes->pants)) {

		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->top_tshirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->pants[$i], $clothes->top_tshirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->shirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->pants[$i], $clothes->shirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->cardigan); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->pants[$i], $clothes->cardigan[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

	}

	if (isset($clothes->skirt)) {
		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->top_tshirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->skirt[$i], $clothes->top_tshirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->shirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->skirt[$i], $clothes->shirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->cardigan); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->skirt[$i], $clothes->cardigan[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}
	}

	if (isset($clothes->short)) {
		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->top_tshirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->short[$i], $clothes->top_tshirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->shirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->short[$i], $clothes->shirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->cardigan); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->short[$i], $clothes->cardigan[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}
	}

	return $looks;
}

function get_torse_looks($clothes) {

	$looks = [];

	if (isset($clothes->vest)) {
		if (isset($clothes->pants)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->vest); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->pants[$i], $clothes->vest[$j], $clothes->accessory[$k]]);
					} 
				}
			}

			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->vest); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						$look = array($clothes->pants[$i], $clothes->vest[$j], $clothes->accessory[$k]);
						array_push($looks, $look);
					} 
				}
			}
		}

		if (isset($clothes->skirt)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->vest); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->skirt[$i], $clothes->vest[$j], $clothes->accessory[$k]]);
					} 
				}
			}
		}

		if (isset($clothes->short)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->vest); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->short[$i], $clothes->vest[$j], $clothes->accessory[$k]]);
					} 
				}
			}
		}
	}

	if (isset($clothes->coat)) {
		if (isset($clothes->pants)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->coat); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->pants[$i], $clothes->coat[$j], $clothes->accessory[$k]]);
					} 
				}
			}
		}

		if (isset($clothes->skirt)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->coat); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->skirt[$i], $clothes->coat[$j], $clothes->accessory[$k]]);
					} 
				}
			}
		}

		if (isset($clothes->short)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->coat); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->short[$i], $clothes->coat[$j], $clothes->accessory[$k]]);
					} 
				}
			}
		}
	}

	if (!isset($clothes->vest) && !isset($clothes->coat)) {
		if (isset($clothes->pants)) {
			for ($i = 0; $i < count($clothes->pants); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->pants[$i], $clothes->accessory[$j]]);
				} 
			}
		}

		if (isset($clothes->skirt)) {
			for ($i = 0; $i < count($clothes->skirt); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->skirt[$i], $clothes->accessory[$j]]);
				} 
			}
		}

		if (isset($clothes->short)) {
			for ($i = 0; $i < count($clothes->short); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->short[$i], $clothes->accessory[$j]]);
				} 
			}
		}
	}

	return $looks;
}

function get_legs_looks($clothes) {

	var_dump('TOTO');
	$looks = [];

	if (isset($clothes->vest)) {
		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->vest); $i++) {
				for ($j = 0; $j < count($clothes->top_tshirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->vest[$i], $clothes->top_tshirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->vest); $i++) {
				for ($j = 0; $j < count($clothes->shirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->vest[$i], $clothes->shirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->vest); $i++) {
				for ($j = 0; $j < count($clothes->cardigan); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->vest[$i], $clothes->cardigan[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}
	}

	if (isset($clothes->coat)) {
		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->coat); $i++) {
				for ($j = 0; $j < count($clothes->top_tshirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->coat[$i], $clothes->top_tshirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->coat); $i++) {
				for ($j = 0; $j < count($clothes->shirt); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->coat[$i], $clothes->shirt[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->coat); $i++) {
				for ($j = 0; $j < count($clothes->cardigan); $j++) {
					for ($k = 0; $k < count($clothes->accessory); $k++) {
						array_push($looks, [$clothes->coat[$i], $clothes->cardigan[$j], $clothes->accessory[$k]]);
					}
				}
			}
		}
	}

	if (!isset($clothes->vest) && !isset($clothes->coat)) {
		if (isset($clothes->top_tshirt)) {
			for ($i = 0; $i < count($clothes->top_tshirt); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->top_tshirt[$i], $clothes->accessory[$j]]);
				}
			}
		}

		if (isset($clothes->shirt)) {
			for ($i = 0; $i < count($clothes->shirt); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->shirt[$i], $clothes->accessory[$j]]);
				}
			}
		}

		if (isset($clothes->cardigan)) {
			for ($i = 0; $i < count($clothes->cardigan); $i++) {
				for ($j = 0; $j < count($clothes->accessory); $j++) {
					array_push($looks, [$clothes->cardigan[$i], $clothes->accessory[$j]]);
				}
			}
		}
	}
	return $looks;
}