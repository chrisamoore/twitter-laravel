<?php

use Faker\Factory as Faker;
use Twitter\Api\User\User;
use Twitter\Api\Message\Message;
use Twitter\Api\Tweet\Tweet;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $faker = Faker::create();

        $users = [];

        $users[] = User::create([
            "email" => "nickknol@gmail.com",
            "handle" => "nickknol",
            "profile_photo" => $faker->imageUrl(),
            "background_photo" => $faker->imageUrl(),
            "bio" => "I am a car ninja!!",
            "website" => "http://www.nickknol.com",
            "active" => true,
            "password" => "password",
        ]);

        foreach (range(1, 5) as $index) {
            $users[] = User::create([
                "email" => $faker->email(),
                "handle" => strtolower($faker->firstName() . "_" . $faker->lastName()),
                "profile_photo" => $faker->imageUrl(),
                "background_photo" => $faker->imageUrl(),
                "bio" => $faker->sentence(),
                "website" => $faker->url(),
                "active" => true,
                "password" => "password",
            ]);
        }

        $tweets = [];
        foreach ($users as $user) {

            $tweets[$user->id] = [];
            foreach (range(1, 10) as $index) {

                $tweets[$user->id][] = Tweet::create([
                    "user_id" => $user->id,
                    "message" => $faker->sentence(),
                    "original_tweet_id" => null,
                ]);
            }
        }

        $messages = [];
        foreach ($users as $fromUser) {

            $messages[$user->id] = [];
            foreach (range(1, 10) as $index) {

                $key = array_rand($users);
                $toUser = $users[$key];

                $tweets[$fromUser->id][] = Message::create([
                    "from_user_id" => $fromUser->id,
                    "to_user_id" => $toUser->id,
                    "message" => $faker->sentence(),
                ]);
            }
        }
	}

}
