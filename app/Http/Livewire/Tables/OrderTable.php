class OrderTable extends Component
{
    public function getOrdersQuery()
    {
        return Order::where('user_id', auth()->id());
    }

    public function render()
    {
        return view('livewire.tables.order-table', [
            'orders' => $this->getOrdersQuery()->paginate(10)
        ]);
    }
} 