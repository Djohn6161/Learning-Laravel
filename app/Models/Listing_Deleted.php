<?php
    namespace App\Models;

    class Listing {
        public static function all(){
            return [
                [
                    'id' => 1,
                    'title' => 'Job One',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                    Optio explicabo atque voluptates tempora quibusdam in nostrum, nisi, corporis, 
                    dicta repellat eos minus culpa iusto dolorem voluptatibus. Vitae, 
                    explicabo doloremque accusamus similique aperiam obcaecati blanditiis
                     recusandae minima officia consequuntur, commodi reiciendis modi tempore 
                     tempora fugit quam numquam impedit? Repellendus, ipsa laboriosam!'
    
                ],
                [
                    'id' => 2,
                    'title' => 'Job Two',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                    Optio explicabo atque voluptates tempora quibusdam in nostrum, nisi, corporis, 
                    dicta repellat eos minus culpa iusto dolorem voluptatibus. Vitae, 
                    explicabo doloremque accusamus similique aperiam obcaecati blanditiis
                     recusandae minima officia consequuntur, commodi reiciendis modi tempore 
                     tempora fugit quam numquam impedit? Repellendus, ipsa laboriosam!'
    
                ],
            ];
        }

        public static function find($id){
            $listings = self::all();

            foreach($listings as $listing){
                if($listing['id'] == $id){
                    return $listing;
                }
            }
        }
    }