var path = "{{url('admin/blacklist/candidate/action')}}";

$('#key').typeahead({

    source: function(query, process) {
        return $.get(path,{query:query},function(data){
            return process(data);
        });
    }
});