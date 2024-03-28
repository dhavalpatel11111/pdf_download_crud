<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Image</th>
            <th>Gender</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td><?php echo $users['id']; ?></td>
            <td><?php echo $users['fname']; ?></td>
            <td><?php echo $users['email']; ?></td>
            <td><?php echo $users['password']; ?></td>
            <td><?php echo $users['img']; ?></td>
            <td><?php echo $users['gender']; ?></td>
        </tr>
    </tbody>
</table>