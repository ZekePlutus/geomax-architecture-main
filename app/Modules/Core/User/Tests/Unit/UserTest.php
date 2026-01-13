<?php

namespace App\Modules\Core\User\Tests\Unit;

use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user fillable attributes.
     */
    public function test_user_has_correct_fillable_attributes(): void
    {
        $user = new User();

        $expected = [
            'user_type_id',
            'company_id',
            'email',
            'password',
            'name',
            'is_active',
            'last_login_at',
        ];

        $this->assertEquals($expected, $user->getFillable());
    }

    /**
     * Test user hidden attributes.
     */
    public function test_user_hides_sensitive_attributes(): void
    {
        $user = new User();

        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    /**
     * Test user casts.
     */
    public function test_user_has_correct_casts(): void
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertEquals('boolean', $casts['is_active']);
        $this->assertEquals('datetime', $casts['last_login_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    /**
     * Test is_active attribute is boolean.
     */
    public function test_is_active_is_cast_to_boolean(): void
    {
        $user = new User(['is_active' => 1]);

        $this->assertIsBool($user->is_active);
        $this->assertTrue($user->is_active);
    }

    /**
     * Test user uses correct table.
     */
    public function test_user_uses_users_table(): void
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
    }

    /**
     * Test user has userType relationship defined.
     */
    public function test_user_has_user_type_relationship(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $user->userType()
        );
    }

    /**
     * Test user has company relationship defined.
     */
    public function test_user_has_company_relationship(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $user->company()
        );
    }

    /**
     * Test user has roles relationship defined.
     */
    public function test_user_has_roles_relationship(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $user->roles()
        );
    }

    /**
     * Test user has effectivePermissions relationship defined.
     */
    public function test_user_has_effective_permissions_relationship(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $user->effectivePermissions()
        );
    }

    /**
     * Test user has restrictions relationship defined.
     */
    public function test_user_has_restrictions_relationship(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $user->restrictions()
        );
    }

    /**
     * Test isResellerOwner returns false when no userType.
     */
    public function test_is_reseller_owner_returns_false_when_no_user_type(): void
    {
        $user = new User();

        $this->assertFalse($user->isResellerOwner());
    }

    /**
     * Test isCompanyAdmin returns false when no userType.
     */
    public function test_is_company_admin_returns_false_when_no_user_type(): void
    {
        $user = new User();

        $this->assertFalse($user->isCompanyAdmin());
    }

    /**
     * Test isDriver returns false when no userType.
     */
    public function test_is_driver_returns_false_when_no_user_type(): void
    {
        $user = new User();

        $this->assertFalse($user->isDriver());
    }
}
