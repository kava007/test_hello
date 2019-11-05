<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        //factory(App\Auto::class, 10)->create();
        factory(App\Cliente::class, 5)->create();

        App\User::create(

            ['name' => 'Karla Valencia',
            'email' => 'karlavalenciagdl@hotmail.com',
            'admin' => 1,
            'password' => bcrypt('12345678')
            ],
        );

        App\User::create(

            ['name' => 'Francico Estrada',
            'email' => 'francisco_estrada@hotmail.com',
            'admin' => 0,
            'password' => bcrypt('festrada')
            ],
        );



        App\Auto::create(

            ['marca' => 'Honda',
            'modelo' => 'Civic',
            'anio'   => '2010'
            ],
        );

        App\Auto::create(

            ['marca' => 'Alfa Romeo',
            'modelo' => 'Stelvio',
            'anio'   => '2019'
            ],
        );

        App\Auto::create(

            ['marca' => 'Audi',
            'modelo' => 'A7',
            'anio'   => '2014'
            ],
        );

        App\Auto::create(

            ['marca' => 'BMW',
            'modelo' => 'X2',
            'anio'   => '2010'
            ],
        );




    	
       
    }
}
