<?php

namespace App\Repositories\destination;

interface DestinationInterface{

    public function getAll();

    public function findById($id);

    public function activeDestinations();

    public function destinationHasHotels();

    public function store($request);

    public  function update($editDestination, $request = []);

    public function delete($destination);

}
