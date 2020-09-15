
Feature:
    To have control over which applications, databases and other important data is under backup mechanism
    I need to be able to define a list of backup collections, edit and delete.

    Scenario: I create a simple backup collection
        Given I create a backup collection described as "CNT-AIT digital documents library" with 5 maximum rotated files of 500mb size
        And I define that backup in the created collection cannot be sent more often than every 168 hours
        Then I should see "CNT-AIT digital documents library" backup collection created
