<?php


namespace App\Repositories\amenity;


interface AmenityInterface
{
    public function getAll();

    public function findById($id);

    public function findBySlug($slug);

    public function storeAmenity($request = []);

    public function updateAmenity($amenity, $request = []);

    public function storeIcon($amenity, $icon);

    public function destroyAmenity($amenity);
}