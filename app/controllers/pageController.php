    <?php
    require_once 'app/models/consumerModel.php';
    class pageController extends Controller
    {
        function consumer() {
            $this->view('consumer');
        }
        function addConsumer() {
            $this->view('add-consumer');
        }
        function editConsumer() {
            $this->view('edit-consumer');
        }
        
}
    ?>