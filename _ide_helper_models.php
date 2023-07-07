<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Agenda
 *
 * @property int $id
 * @property string $title
 * @property int|null $chairman
 * @property int|null $vice_chairman
 * @property int $index
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SanggunianMember|null $chairman_information
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AgendaMember> $members
 * @property-read int|null $members_count
 * @property-read \App\Models\SanggunianMember|null $vice_chairman_information
 * @method static \Illuminate\Database\Eloquent\Builder|Agenda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agenda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agenda query()
 */
	class Agenda extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AgendaMember
 *
 * @property int $id
 * @property int $agenda_id
 * @property int $member
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agenda|null $agenda
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SanggunianMember> $sanggunian_member
 * @property-read int|null $sanggunian_member_count
 * @method static \Illuminate\Database\Eloquent\Builder|AgendaMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgendaMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgendaMember query()
 */
	class AgendaMember extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BoardSession
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $file_path
 * @property string|null $unassigned_title
 * @property string|null $unassigned_business
 * @property string|null $announcement_title
 * @property string|null $announcement_content
 * @property string $status
 * @property int|null $locked_by
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardSession withoutTrashed()
 */
	class BoardSession extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Committee
 *
 * @property int $id
 * @property string $name
 * @property int|null $display_index
 * @property int|null $lead_committee
 * @property int|null $expanded_committee
 * @property string|null $file_path
 * @property string|null $content
 * @property bool $invited_guests
 * @property string $status
 * @property string|null $returned_message
 * @property int|null $submitted_by
 * @property int|null $schedule_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agenda|null $expanded_committee_information
 * @property-read mixed $file
 * @property-read mixed $file_name
 * @property-read \App\Models\Agenda|null $lead_committee_information
 * @property-read \App\Models\User|null $submitted
 * @method static \Illuminate\Database\Eloquent\Builder|Committee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Committee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Committee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Committee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Committee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Committee withoutTrashed()
 */
	class Committee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Division
 *
 * @property int $id
 * @property string $name
 * @property string|null $division_code
 * @property string $description
 * @property int|null $board
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SanggunianMember|null $board_member
 * @method static \Illuminate\Database\Eloquent\Builder|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder|Division withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Division withoutTrashed()
 */
	class Division extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LoginHistory
 *
 * @property int $id
 * @property string $ip_address
 * @property int $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $logged_in_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory query()
 */
	class LoginHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SanggunianMember
 *
 * @property int $id
 * @property string $fullname
 * @property string $district
 * @property string $sanggunian
 * @property string $profile_picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SanggunianMember withoutTrashed()
 */
	class SanggunianMember extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $date_and_time
 * @property string|null $description
 * @property string $venue
 * @property bool $with_invited_guest
 * @property string|null $schedule
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Committee> $committees
 * @property-read int|null $committees_count
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 */
	class Schedule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $suffix
 * @property string $username
 * @property string $password
 * @property string $account_type
 * @property \App\Enums\UserStatus $status
 * @property string $profile_picture
 * @property int|null $division
 * @property bool $is_online
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAccess> $access
 * @property-read int|null $access_count
 * @property-read User|null $committee
 * @property-read \App\Models\Division|null $division_information
 * @property-read \App\Models\LoginHistory|null $login_histories
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAccess
 *
 * @property int $id
 * @property int|null $user
 * @property int|null $agenda
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess query()
 */
	class UserAccess extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property string $uuid
 * @property int $user
 * @property int $submitted_by
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $sender_information
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 */
	class UserNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Venue
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue query()
 */
	class Venue extends \Eloquent {}
}

