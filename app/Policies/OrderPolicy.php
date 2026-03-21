<?php

namespace App\Policies;

use App\Models\User;

class OrderPolicy
{
        /**
         * Determine if the user can view the order list.
         */
        public function index(User $user): bool
        {
            return $user->isCustomer();
        }

        /**
         * Determine if the user can add to cart.
         */
        public function addToCart(User $user): bool
        {
            return $user->isCustomer();
        }

        /**
         * Determine if the user can remove from cart.
         */
        public function remove(User $user): bool
        {
            return $user->isCustomer();
        }
        /**
         * Determine admin can see all the orders.
         */
        public function allOrders() {
            return $user->isAdmin();
        }
}
