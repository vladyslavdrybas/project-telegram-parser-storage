<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ChannelCommunitySupportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChannelCommunitySupportRepository::class)
 * @ORM\Table(
 *     name="channel_community_support",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"channel_id", "community_id"})}

 * )
 */
class ChannelCommunitySupport extends AbstractEntity
{
    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      notInRangeMessage = "Support must be between {{ min }}% and {{ max }}%",
     * )
     * @ORM\Column(name="support_rate", type="integer", options={"default":0})
     * @Groups({"show_channelcommunitysupport", "list"})
     */
    protected int $supportRate = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="channelCommunitySupports")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     * @Groups({"show_channelcommunitysupport", "list"})
     */
    protected Channel $channel;

    /**
     * @ORM\ManyToOne(targetEntity="Community", inversedBy="channelCommunitySupports")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
     * @Groups({"show_channelcommunitysupport", "list"})
     */
    protected Community $community;
}
