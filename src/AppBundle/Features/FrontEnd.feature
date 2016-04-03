Feature: Prueba del Front End
    Prueba de funcionamiento de la app accendiendo a la página del index

    Scenario: Se accede correctamente a la pagina de index
        Given I am on the homepage
        Then I should see "Welcome" in the "h1" element

    @javascript
    Scenario: Open the bootstrap modal dialog
        Given I am on the homepage
        And I should see "Demo Modal"
        When I press "Demo Modal"
        Then After the modal "Modal title" opens
        Then I should see "Modal Body"