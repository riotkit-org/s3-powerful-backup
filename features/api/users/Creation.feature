
Feature:
    In order to allow multiple people access to the system I need to be able to create user accounts.

    Scenario: I create an admin account
        # Given I am authenticated as ...
        When I create admin "iwa-ait@riotkit.org" identified with "super-complex-password" from "International Workers Association" organization
        Then I should see confirmation about created user account
