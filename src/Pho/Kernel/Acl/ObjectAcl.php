<?php

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\Kernel\Acl;

use Pho\Lib\Graph;
use Pho\Framework;

class ObjectAcl extends AbstractAcl implements AclInterface {

    public function isSubscriber(Framework\Actor $actor): bool
    {
        return
            (
                in_array(\Pho\Framework\ActorOut\Subscribe::class, $this->core->creator()->getRegisteredIncomingEdges()) 
                && $this->core->creator()->hasSubscriber($actor->id())
            );
    }

}