<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Proposal;

class ProposalPolicy
{
    public function view(User $user, Proposal $proposal)
    {
        return $user->role === 'kaprodi' || 
               $user->id === $proposal->user_id;
    }

    public function update(User $user, Proposal $proposal)
    {
        return $proposal->status === 'draft' && 
               $user->id === $proposal->user_id;
    }

    public function delete(User $user, Proposal $proposal)
    {
        return $proposal->status === 'draft' && 
               $user->id === $proposal->user_id;
    }

    public function changeStatus(User $user, Proposal $proposal)
    {
        return $user->role === 'kaprodi';
    }
}